<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function __construct(
        private readonly CacheService $cacheService
    ) {
    }

    /**
     * Display the FAQ page with cached content.
     */
    public function index(): View
    {
        $locale = app()->getLocale();
        
        /** @var array<string, array<string, mixed>> $faqData */
        $faqData = $this->cacheService->getFAQLocalized($locale);
        
        return view('pages.faq', compact('faqData'));
    }
}
