<?php

namespace App\Http\Middleware;

use App\Enums\Locale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware for automatic locale detection and setting.
 * 
 * Detects the user's preferred language from multiple sources:
 * 1. URL parameter (?lang=de)
 * 2. Session storage
 * 3. Accept-Language header
 * 4. Application default
 */
class LocaleMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->detectLocale($request);
        
        // Set the application locale
        App::setLocale($locale->value);
        
        // Store the locale in session for future requests
        Session::put('locale', $locale->value);
        
        return $next($request);
    }

    /**
     * Detect the preferred locale for the user.
     * 
     * Priority order:
     * 1. URL parameter (?lang=de)
     * 2. Session stored locale
     * 3. Accept-Language header from browser
     * 4. Application default locale
     */
    private function detectLocale(Request $request): Locale
    {
        // 1. Check URL parameter first (highest priority)
        $urlLocale = $request->query('lang');
        if (is_string($urlLocale)) {
            $locale = Locale::fromString($urlLocale);
            if ($locale !== null) {
                return $locale;
            }
        }

        // 2. Check session stored locale
        $sessionLocale = Session::get('locale');
        if (is_string($sessionLocale)) {
            $locale = Locale::fromString($sessionLocale);
            if ($locale !== null) {
                return $locale;
            }
        }

        // 3. Parse Accept-Language header from browser
        $browserPreferences = $this->parseAcceptLanguage($request);
        if (!empty($browserPreferences)) {
            $locale = Locale::getPreferred($browserPreferences);
            return $locale;
        }

        // 4. Fall back to application default
        return Locale::default();
    }

    /**
     * Parse the Accept-Language header to get ordered language preferences.
     *
     * @return array<string>
     */
    private function parseAcceptLanguage(Request $request): array
    {
        $acceptLanguage = $request->header('Accept-Language');
        
        if (!$acceptLanguage) {
            return [];
        }

        // Parse Accept-Language header (e.g., "de-DE,de;q=0.9,en;q=0.8")
        $languages = [];
        $parts = explode(',', $acceptLanguage);
        
        foreach ($parts as $part) {
            $part = trim($part);
            
            // Check if there's a quality value (q=0.9)
            if (strpos($part, ';') !== false) {
                [$language, $quality] = explode(';', $part, 2);
                $quality = (float) str_replace('q=', '', $quality);
            } else {
                $language = $part;
                $quality = 1.0;
            }
            
            // Extract primary language code (de-DE -> de)
            $primaryLanguage = strtolower(explode('-', trim($language))[0]);
            
            $languages[$primaryLanguage] = $quality;
        }

        // Sort by quality (highest first)
        arsort($languages);
        
        // Return ordered list of language codes
        return array_keys($languages);
    }

    /**
     * Get the list of supported locale codes.
     *
     * @return array<string>
     */
    public function getSupportedLocales(): array
    {
        return Locale::supportedCodes();
    }
}
