<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\ThemeService;
use App\Enums\Theme;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Theme Management API Endpoints
 */
Route::middleware(['web'])->group(function () {
    // Set theme preference
    Route::post('/theme/set', function (Request $request, ThemeService $themeService) {
        $request->validate([
            'theme' => ['required', 'string', 'in:light,dark']
        ]);

        $theme = Theme::from($request->string('theme'));
        $themeService->setTheme($theme);

        return response()->json([
            'success' => true,
            'theme' => $theme->value,
            'message' => __('messages.theme.switched_to', ['theme' => $theme->getDisplayName()])
        ]);
    })->name('api.theme.set');

    // Get current theme
    Route::get('/theme/current', function (ThemeService $themeService) {
        return response()->json([
            'current' => $themeService->getCurrentTheme()->value,
            'data' => $themeService->getThemeData()
        ]);
    })->name('api.theme.current');

    // Toggle theme
    Route::post('/theme/toggle', function (ThemeService $themeService) {
        $newTheme = $themeService->toggleTheme();

        return response()->json([
            'success' => true,
            'theme' => $newTheme->value,
            'message' => __('messages.theme.switched_to', ['theme' => $newTheme->getDisplayName()])
        ]);
    })->name('api.theme.toggle');
});