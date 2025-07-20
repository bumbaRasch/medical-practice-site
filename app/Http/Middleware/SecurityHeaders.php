<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Security Headers Middleware
 * 
 * Implements comprehensive security headers for medical practice website
 * following OWASP recommendations and healthcare security best practices.
 */
class SecurityHeaders
{
    /**
     * Handle an incoming request and add security headers to the response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Apply security headers based on environment and request type
        $this->addTransportSecurityHeaders($response, $request);
        $this->addContentSecurityHeaders($response, $request);
        $this->addFramingHeaders($response, $request);
        $this->addContentTypeHeaders($response, $request);
        $this->addReferrerHeaders($response, $request);
        $this->addFeaturePolicyHeaders($response, $request);
        $this->addMedicalPracticeHeaders($response, $request);

        return $response;
    }

    /**
     * Add HTTP Strict Transport Security (HSTS) headers.
     */
    private function addTransportSecurityHeaders(Response $response, Request $request): void
    {
        // Only add HSTS if request is over HTTPS
        if ($request->isSecure()) {
            // 1 year HSTS with includeSubDomains and preload
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        // Force HTTPS in production
        if (app()->environment('production') && !$request->isSecure()) {
            // This should be handled by load balancer/proxy, but add as backup
            $response->headers->set('X-Force-HTTPS', '1');
        }
    }

    /**
     * Add Content Security Policy headers.
     */
    private function addContentSecurityHeaders(Response $response, Request $request): void
    {
        // Build CSP based on environment
        $csp = $this->buildContentSecurityPolicy($request);
        
        if (app()->environment('local')) {
            // Use report-only in development for testing
            $response->headers->set('Content-Security-Policy-Report-Only', $csp);
        } else {
            // Enforce CSP in staging/production
            $response->headers->set('Content-Security-Policy', $csp);
        }

        // Add CSP nonce for inline scripts if needed
        if ($request->routeIs('contact') || $request->routeIs('faq')) {
            $nonce = base64_encode(random_bytes(16));
            $request->attributes->set('csp_nonce', $nonce);
        }
    }

    /**
     * Build Content Security Policy string.
     */
    private function buildContentSecurityPolicy(Request $request): string
    {
        $host = $request->getHost();
        $isLocal = app()->environment('local');
        
        $policies = [
            // Default source - allow same origin
            "default-src 'self'",
            
            // Scripts - allow same origin, unsafe-inline for Blade, and specific CDNs
            "script-src 'self' 'unsafe-inline'" . 
            ($isLocal ? " 'unsafe-eval'" : '') . // Allow eval in development for Vite
            " https://unpkg.com https://cdn.jsdelivr.net", // For Leaflet.js and other CDNs
            
            // Styles - allow same origin, unsafe-inline for Tailwind, and CDNs
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            
            // Images - allow same origin, data URLs, and practice images
            "img-src 'self' data: https: blob:", // Allow external images for maps and practice photos
            
            // Fonts - allow same origin and Google Fonts
            "font-src 'self' https://fonts.gstatic.com",
            
            // Connect - allow same origin and necessary API endpoints
            "connect-src 'self'" . 
            ($isLocal ? " ws://localhost:* ws://127.0.0.1:*" : '') . // Vite HMR in development
            " https://api.openstreetmap.org https://tile.openstreetmap.org", // For maps
            
            // Media - allow same origin only
            "media-src 'self'",
            
            // Objects - disallow all (security best practice)
            "object-src 'none'",
            
            // Base URI - restrict to same origin
            "base-uri 'self'",
            
            // Form actions - allow same origin only (contact form security)
            "form-action 'self'",
            
            // Frame ancestors - prevent clickjacking
            "frame-ancestors 'none'",
            
            // Block mixed content
            "block-all-mixed-content",
            
            // Upgrade insecure requests in production
            app()->environment('production') ? "upgrade-insecure-requests" : '',
        ];

        return implode('; ', array_filter($policies));
    }

    /**
     * Add anti-clickjacking headers.
     */
    private function addFramingHeaders(Response $response, Request $request): void
    {
        // Prevent clickjacking attacks - medical sites are common targets
        $response->headers->set('X-Frame-Options', 'DENY');
        
        // Modern replacement for X-Frame-Options (already in CSP but explicit is better)
        $response->headers->set('X-Content-Type-Options', 'nosniff');
    }

    /**
     * Add content type security headers.
     */
    private function addContentTypeHeaders(Response $response, Request $request): void
    {
        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // XSS protection (legacy but still useful)
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // DNS prefetch control for privacy
        $response->headers->set('X-DNS-Prefetch-Control', 'off');
    }

    /**
     * Add referrer policy headers.
     */
    private function addReferrerHeaders(Response $response, Request $request): void
    {
        // Strict referrer policy for patient privacy
        // Only send referrer for same-origin requests
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    /**
     * Add permissions policy headers (formerly Feature Policy).
     */
    private function addFeaturePolicyHeaders(Response $response, Request $request): void
    {
        // Disable potentially dangerous browser features
        $policies = [
            'accelerometer=()',      // No device motion
            'camera=()',            // No camera access
            'geolocation=(self)',   // Allow geolocation for practice location
            'gyroscope=()',         // No gyroscope
            'magnetometer=()',      // No magnetometer
            'microphone=()',        // No microphone
            'payment=()',           // No payment request API
            'usb=()',              // No USB access
            'fullscreen=(self)',    // Allow fullscreen for maps
            'picture-in-picture=()', // No PiP
        ];

        $response->headers->set('Permissions-Policy', implode(', ', $policies));
    }

    /**
     * Add medical practice specific security headers.
     */
    private function addMedicalPracticeHeaders(Response $response, Request $request): void
    {
        // Add custom headers for medical practice context
        $response->headers->set('X-Medical-Practice', 'true');
        $response->headers->set('X-Patient-Privacy', 'protected');
        
        // Cache control for sensitive pages
        if ($this->isSensitivePage($request)) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, private');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        // Add security contact information
        $response->headers->set('X-Security-Contact', 'security@' . $request->getHost());

        // Add content language for accessibility
        $locale = app()->getLocale();
        $response->headers->set('Content-Language', $locale);
    }

    /**
     * Determine if the current page contains sensitive information.
     */
    private function isSensitivePage(Request $request): bool
    {
        // Pages that might contain sensitive patient information
        $sensitiveRoutes = [
            'contact',           // Contact form with patient data
            'form.request.submit', // Form submission endpoint
        ];

        return $request->routeIs($sensitiveRoutes);
    }
}