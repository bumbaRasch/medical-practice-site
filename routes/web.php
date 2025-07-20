<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FormRequestController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\SitemapController;

// Cached public pages (cacheable static content)
Route::middleware(['responsecache'])->group(function () {
    // Home page
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Static pages
    Route::get('/leistungen', [ServicesController::class, 'index'])->name('services');
    Route::get('/team', [TeamController::class, 'index'])->name('team');
    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::get('/kontakt', [ContactController::class, 'index'])->name('contact');
    
    // SEO sitemap - cached for performance
    Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
});

// Non-cached routes (dynamic content)
Route::group([], function () {
    // Contact form submission with rate limiting
    Route::post('/form/request', [FormRequestController::class, 'submit'])
        ->middleware('throttle:5,1')  // 5 requests per minute per IP
        ->name('form.submit');

    // Legal pages (might change less frequently, but keeping uncached for compliance)
    Route::get('/datenschutz', [LegalController::class, 'privacy'])->name('legal.privacy');
    Route::get('/impressum', [LegalController::class, 'imprint'])->name('legal.imprint');
    Route::get('/agb', [LegalController::class, 'terms'])->name('legal.terms');
});
