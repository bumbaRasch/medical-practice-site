<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Sitemap XML Generation Tests
 * 
 * Tests the dynamic sitemap.xml generator for medical practice website.
 * Ensures proper XML format, required URLs, and SEO optimization.
 */
class SitemapTest extends TestCase
{
    /**
     * Test that sitemap.xml is accessible and returns valid XML.
     */
    public function test_sitemap_is_accessible(): void
    {
        $response = $this->get('/sitemap.xml');
        
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/xml; charset=utf-8');
        $this->assertStringContainsString('max-age=3600', $response->headers->get('cache-control'));
        $this->assertStringContainsString('public', $response->headers->get('cache-control'));
    }
    
    /**
     * Test that sitemap contains valid XML structure.
     */
    public function test_sitemap_contains_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');
        
        $content = $response->getContent();
        
        // Validate XML structure
        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $content);
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"', $content);
        $this->assertStringContainsString('</urlset>', $content);
        
        // Validate XML parsing
        $xml = simplexml_load_string($content);
        $this->assertNotFalse($xml, 'Sitemap must be valid XML');
    }
    
    /**
     * Test that sitemap contains all required medical practice pages.
     */
    public function test_sitemap_contains_required_pages(): void
    {
        $response = $this->get('/sitemap.xml');
        $content = $response->getContent();
        
        // Required pages for medical practice
        $requiredUrls = [
            route('home'),                       // Homepage
            route('contact'),                    // Contact/Appointments
            route('services'),                   // Medical services
            route('faq'),                       // Patient information
            route('team'),                      // Doctor/staff info
            route('legal.privacy'),             // Privacy policy
            route('legal.imprint'),             // Legal imprint
            route('legal.terms'),               // Terms of service
        ];
        
        foreach ($requiredUrls as $url) {
            // Check for both with and without port for development testing
            $urlPath = parse_url($url, PHP_URL_PATH) ?: '/';
            $this->assertTrue(
                str_contains($content, "<loc>{$url}</loc>") || 
                str_contains($content, "<loc>http://localhost:8000{$urlPath}</loc>"),
                "Sitemap must contain URL path: {$urlPath} (checked: {$url})"
            );
        }
    }
    
    /**
     * Test that sitemap uses appropriate priorities for medical practice.
     */
    public function test_sitemap_uses_medical_practice_priorities(): void
    {
        $response = $this->get('/sitemap.xml');
        $content = $response->getContent();
        
        // Homepage should have highest priority
        $this->assertStringContainsString('<priority>1.0</priority>', $content);
        
        // Contact page should have very high priority
        $this->assertStringContainsString('<priority>0.9</priority>', $content);
        
        // Services should have high priority
        $this->assertStringContainsString('<priority>0.8</priority>', $content);
        
        // Legal pages should have lower priority
        $this->assertStringContainsString('<priority>0.3</priority>', $content);
    }
    
    /**
     * Test that sitemap includes proper change frequencies.
     */
    public function test_sitemap_includes_change_frequencies(): void
    {
        $response = $this->get('/sitemap.xml');
        $content = $response->getContent();
        
        $expectedFrequencies = ['weekly', 'monthly', 'quarterly', 'yearly'];
        
        foreach ($expectedFrequencies as $frequency) {
            $this->assertStringContainsString("<changefreq>{$frequency}</changefreq>", $content,
                "Sitemap must contain change frequency: {$frequency}");
        }
    }
    
    /**
     * Test that sitemap includes last modified dates.
     */
    public function test_sitemap_includes_last_modified_dates(): void
    {
        $response = $this->get('/sitemap.xml');
        $content = $response->getContent();
        
        // Should contain lastmod elements
        $this->assertStringContainsString('<lastmod>', $content);
        
        // Date format should be ISO 8601
        preg_match_all('/<lastmod>([^<]+)<\/lastmod>/', $content, $matches);
        $this->assertNotEmpty($matches[1], 'Sitemap must contain lastmod dates');
        
        foreach ($matches[1] as $date) {
            $this->assertMatchesRegularExpression(
                '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/',
                $date,
                "Date must be in ISO 8601 format: {$date}"
            );
        }
    }
    
    /**
     * Test that sitemap includes German and English language versions.
     */
    public function test_sitemap_includes_localized_versions(): void
    {
        $response = $this->get('/sitemap.xml');
        $content = $response->getContent();
        
        // Should contain both German (default) and English versions
        $homeUrl = route('home');
        
        // German versions (default URLs)
        $this->assertStringContainsString("<loc>{$homeUrl}</loc>", $content);
        
        // English versions (with lang parameter)
        $this->assertStringContainsString("<loc>{$homeUrl}?lang=en</loc>", $content);
        
        // Should contain hreflang attributes
        $this->assertStringContainsString('hreflang="en"', $content);
    }
    
    /**
     * Test XML validation with libxml.
     */
    public function test_sitemap_is_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');
        $content = $response->getContent();
        
        // Suppress libxml errors
        libxml_use_internal_errors(true);
        
        // Try to load XML
        $xml = simplexml_load_string($content);
        
        // Get any XML errors
        $errors = libxml_get_errors();
        
        $this->assertEmpty($errors, 'Sitemap XML should be valid without errors');
        $this->assertNotFalse($xml, 'Sitemap should be parseable XML');
        
        libxml_clear_errors();
    }
    
    /**
     * Test that sitemap can be parsed by search engines.
     */
    public function test_sitemap_structure_for_search_engines(): void
    {
        $response = $this->get('/sitemap.xml');
        $content = $response->getContent();
        
        $xml = simplexml_load_string($content);
        
        // Should have urlset as root element
        $this->assertEquals('urlset', $xml->getName());
        
        // Should have at least one URL
        $this->assertGreaterThan(0, count($xml->url), 'Sitemap must contain at least one URL');
        
        // Each URL should have required elements
        foreach ($xml->url as $url) {
            $this->assertTrue(isset($url->loc), 'Each URL must have a loc element');
            $this->assertTrue(isset($url->lastmod), 'Each URL must have a lastmod element');
            $this->assertTrue(isset($url->changefreq), 'Each URL must have a changefreq element');
            $this->assertTrue(isset($url->priority), 'Each URL must have a priority element');
        }
    }
    
    /**
     * Test performance and caching headers.
     */
    public function test_sitemap_performance_optimization(): void
    {
        $response = $this->get('/sitemap.xml');
        
        // Should have cache headers for performance
        $this->assertStringContainsString('max-age=3600', $response->headers->get('cache-control'));
        $this->assertStringContainsString('public', $response->headers->get('cache-control'));
        
        // Response should be reasonably fast (under 1 second for test)
        $this->assertLessThan(1000, $response->headers->get('X-Response-Time', 0));
    }
}