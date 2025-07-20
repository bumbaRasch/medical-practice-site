<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

/**
 * Dynamic Sitemap Generator for Medical Practice Website
 * 
 * Generates XML sitemap with proper SEO optimization for healthcare websites.
 * Includes all public pages with appropriate priorities and update frequencies.
 */
class SitemapController extends Controller
{
    /**
     * Generate and return the XML sitemap.
     */
    public function index(): Response
    {
        $urls = $this->generateSitemapUrls();
        
        $xml = $this->generateXmlSitemap($urls);
        
        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600', // Cache for 1 hour
        ]);
    }
    
    /**
     * Generate sitemap URLs with medical practice specific priorities.
     * 
     * @return array<int, array<string, string>>
     */
    private function generateSitemapUrls(): array
    {
        $urls = [];
        $lastModified = $this->getLastModifiedDate();
        
        // Homepage - Highest priority for medical practices
        $urls[] = [
            'url' => route('home'),
            'lastmod' => $lastModified,
            'changefreq' => 'weekly',
            'priority' => '1.0',
        ];
        
        // Contact page - Critical for patient acquisition
        $urls[] = [
            'url' => route('contact'),
            'lastmod' => $lastModified,
            'changefreq' => 'monthly',
            'priority' => '0.9',
        ];
        
        // Services page - Essential for medical SEO
        $urls[] = [
            'url' => route('services'),
            'lastmod' => $lastModified,
            'changefreq' => 'monthly',
            'priority' => '0.8',
        ];
        
        // FAQ page - Important for patient information
        $urls[] = [
            'url' => route('faq'),
            'lastmod' => $lastModified,
            'changefreq' => 'monthly',
            'priority' => '0.7',
        ];
        
        // Team page - Important for trust building
        $urls[] = [
            'url' => route('team'),
            'lastmod' => $lastModified,
            'changefreq' => 'quarterly',
            'priority' => '0.6',
        ];
        
        // Legal pages - Required but lower priority
        $legalPages = [
            'legal.privacy' => ['changefreq' => 'yearly', 'priority' => '0.3'],
            'legal.imprint' => ['changefreq' => 'yearly', 'priority' => '0.3'],
            'legal.terms' => ['changefreq' => 'yearly', 'priority' => '0.3'],
        ];
        
        foreach ($legalPages as $routeName => $config) {
            if (Route::has($routeName)) {
                $urls[] = [
                    'url' => route($routeName),
                    'lastmod' => $lastModified,
                    'changefreq' => $config['changefreq'],
                    'priority' => $config['priority'],
                ];
            }
        }
        
        // Add localized versions if multiple languages are supported
        $urls = $this->addLocalizedUrls($urls);
        
        return $urls;
    }
    
    /**
     * Add localized URLs for international SEO.
     * 
     * @param array<int, array<string, string>> $urls
     * @return array<int, array<string, string>>
     */
    private function addLocalizedUrls(array $urls): array
    {
        $locales = ['de', 'en']; // German and English
        $localizedUrls = [];
        
        foreach ($urls as $url) {
            foreach ($locales as $locale) {
                if ($locale === 'de') {
                    // German is default - already included
                    $localizedUrls[] = $url;
                } else {
                    // Add English versions with language parameter
                    $localizedUrls[] = [
                        'url' => $url['url'] . '?lang=' . $locale,
                        'lastmod' => $url['lastmod'],
                        'changefreq' => $url['changefreq'],
                        'priority' => $url['priority'],
                        'hreflang' => $locale,
                    ];
                }
            }
        }
        
        return $localizedUrls;
    }
    
    /**
     * Generate XML sitemap from URLs array.
     * 
     * @param array<int, array<string, string>> $urls
     */
    private function generateXmlSitemap(array $urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
        
        foreach ($urls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url['url'], ENT_XML1) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . "\n";
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . "\n";
            
            // Add hreflang for international SEO
            if (isset($url['hreflang'])) {
                $xml .= '    <xhtml:link rel="alternate" hreflang="' . $url['hreflang'] . '" href="' . htmlspecialchars($url['url'], ENT_XML1) . '" />' . "\n";
            }
            
            $xml .= '  </url>' . "\n";
        }
        
        $xml .= '</urlset>';
        
        return $xml;
    }
    
    /**
     * Get the last modified date for sitemap entries.
     * 
     * In production, this could check actual file modification times
     * or database timestamps for dynamic content.
     */
    private function getLastModifiedDate(): string
    {
        // For static medical practice website, use deployment/build date
        $buildDate = $this->getBuildDate();
        
        if ($buildDate) {
            return $buildDate;
        }
        
        // Fallback to current date formatted for XML sitemap
        return Carbon::now()->toISOString() ?? Carbon::now()->format('c');
    }
    
    /**
     * Get build/deployment date from various sources.
     */
    private function getBuildDate(): ?string
    {
        // Check for build timestamp file (created during deployment)
        $buildTimestampFile = base_path('.build-timestamp');
        if (file_exists($buildTimestampFile)) {
            $timestamp = (int) file_get_contents($buildTimestampFile);
            return Carbon::createFromTimestamp($timestamp)->toISOString();
        }
        
        // Check Git commit date if available
        if (is_dir(base_path('.git'))) {
            try {
                $gitDate = exec('cd ' . base_path() . ' && git log -1 --format=%cd --date=iso-strict 2>/dev/null');
                if ($gitDate) {
                    return Carbon::parse($gitDate)->toISOString();
                }
            } catch (\Exception) {
                // Git not available or error occurred
            }
        }
        
        // Check application files modification time
        $appFiles = [
            app_path('Http/Controllers'),
            resource_path('views'),
            base_path('routes/web.php'),
        ];
        
        $latestModTime = 0;
        foreach ($appFiles as $path) {
            if (file_exists($path)) {
                $modTime = is_dir($path) ? $this->getDirectoryModTime($path) : filemtime($path);
                $latestModTime = max($latestModTime, $modTime);
            }
        }
        
        if ($latestModTime > 0) {
            return Carbon::createFromTimestamp($latestModTime)->toISOString();
        }
        
        return null;
    }
    
    /**
     * Get the latest modification time for files in a directory.
     */
    private function getDirectoryModTime(string $directory): int
    {
        $latestTime = 0;
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            /** @var \SplFileInfo $file */
            if ($file->isFile() && $file->getExtension() === 'php') {
                $latestTime = max($latestTime, $file->getMTime());
            }
        }
        
        return $latestTime;
    }
}