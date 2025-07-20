<?php

namespace App\Http\CacheProfiles;

use Illuminate\Http\Request;
use Spatie\ResponseCache\CacheProfiles\BaseCacheProfile;
use Symfony\Component\HttpFoundation\Response;

/**
 * Custom cache profile for the medical website.
 * 
 * This profile caches public pages but excludes dynamic content
 * like contact forms and admin areas.
 */
class MedicalWebsiteCacheProfile extends BaseCacheProfile
{
    /**
     * Determine if the request should be cached.
     */
    public function shouldCacheRequest(Request $request): bool
    {
        // Only cache GET requests
        if (!$request->isMethod('GET')) {
            return false;
        }

        // Don't cache if user is authenticated (future-proofing)
        if ($request->user()) {
            return false;
        }

        // Don't cache requests with query parameters (except lang)
        $allowedParams = ['lang'];
        $queryParams = array_keys($request->query());
        $hasDisallowedParams = !empty(array_diff($queryParams, $allowedParams));
        
        if ($hasDisallowedParams) {
            return false;
        }

        // Don't cache specific routes
        $excludedRoutes = [
            'form.submit',           // Contact form submission
            'legal.*',              // Legal pages (privacy, terms)
        ];

        $currentRoute = $request->route()?->getName();
        if ($currentRoute) {
            foreach ($excludedRoutes as $pattern) {
                if (fnmatch($pattern, $currentRoute)) {
                    return false;
                }
            }
        }

        // Don't cache specific paths
        $excludedPaths = [
            '/api/*',
            '/admin/*',
            '/dashboard/*',
            '/_debugbar/*',
        ];

        $path = $request->getPathInfo();
        foreach ($excludedPaths as $pattern) {
            if (fnmatch($pattern, $path)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if the response should be cached.
     */
    public function shouldCacheResponse(Response $response): bool
    {
        // Only cache successful responses
        if (!$response->isSuccessful()) {
            return false;
        }

        // Don't cache responses with specific headers
        if ($response->headers->has('Set-Cookie')) {
            return false;
        }

        // Don't cache responses that are already cached by browser
        if ($response->headers->has('Cache-Control')) {
            $cacheControl = $response->headers->get('Cache-Control');
            if ($cacheControl !== null && str_contains($cacheControl, 'no-cache')) {
                return false;
            }
        }

        return true;
    }

    /**
     * Generate a cache key for the request.
     */
    public function cacheNameSuffix(Request $request): string
    {
        $suffix = [];

        // Include locale in cache key
        if ($request->has('lang')) {
            $langParam = $request->get('lang');
            $suffix[] = 'lang_' . (is_string($langParam) ? $langParam : 'de');
        } else {
            // Include current locale from app
            $suffix[] = 'lang_' . app()->getLocale();
        }

        // Include route name for better organization
        $routeName = $request->route()?->getName();
        if ($routeName) {
            $suffix[] = 'route_' . str_replace('.', '_', $routeName);
        }

        return implode('_', $suffix);
    }

    /**
     * Return cache tags for this request.
     * 
     * @return array<string>
     */
    public function cacheRequestTags(Request $request): array
    {
        $tags = ['website'];

        // Add route-specific tags
        $routeName = $request->route()?->getName();
        if ($routeName) {
            $tags[] = "route:{$routeName}";
            
            // Add page-type tags
            if (str_starts_with($routeName, 'services')) {
                $tags[] = 'services';
            } elseif (str_starts_with($routeName, 'team')) {
                $tags[] = 'team';
            } elseif (str_starts_with($routeName, 'events')) {
                $tags[] = 'events';
            } elseif ($routeName === 'home') {
                $tags[] = 'homepage';
            }
        }

        // Add locale tag
        $locale = $request->get('lang', app()->getLocale());
        $localeString = is_string($locale) ? $locale : app()->getLocale();
        $tags[] = "locale:{$localeString}";

        return $tags;
    }
}