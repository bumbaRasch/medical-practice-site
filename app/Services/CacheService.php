<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * Service for managing cached content blocks to improve performance.
 * 
 * This service handles caching of static content like practice services,
 * team members, opening hours, and other repeated content blocks.
 */
class CacheService
{
    /** @var int Cache TTL in seconds (24 hours) */
    private const CACHE_TTL = 86400;
    
    /** @var string Cache key prefix for practice content */
    private const PRACTICE_PREFIX = 'practice:';
    
    /** @var string Cache key prefix for localized content */
    private const LOCALE_PREFIX = 'locale:';

    /**
     * Get cached practice services with fallback to config.
     *
     * @return array<int, array<string, string>>
     */
    public function getPracticeServices(): array
    {
        /** @var array<int, array<string, string>> */
        return Cache::remember(
            self::PRACTICE_PREFIX . 'services',
            self::CACHE_TTL,
            function (): array {
                $services = Config::get('practice.services', []);
                return is_array($services) ? $services : [];
            }
        );
    }

    /**
     * Get cached practice team members with fallback to config.
     *
     * @return array<int, array<string, string>>
     */
    public function getPracticeTeam(): array
    {
        /** @var array<int, array<string, string>> */
        return Cache::remember(
            self::PRACTICE_PREFIX . 'team',
            self::CACHE_TTL,
            function (): array {
                $team = Config::get('practice.team', []);
                return is_array($team) ? $team : [];
            }
        );
    }

    /**
     * Get cached practice team members with locale-specific translations.
     *
     * @param string $locale
     * @return array<int, array<string, string>>
     */
    public function getPracticeTeamLocalized(string $locale): array
    {
        /** @var array<int, array<string, string>> */
        return Cache::remember(
            self::LOCALE_PREFIX . $locale . ':team',
            self::CACHE_TTL,
            function () use ($locale): array {
                $teamConfig = Config::get('practice.team', []);
                if (!is_array($teamConfig)) {
                    return [];
                }
                
                $localizedTeam = [];

                foreach ($teamConfig as $member) {
                    if (!is_array($member)) {
                        continue;
                    }
                    
                    $name = is_string($member['name'] ?? '') ? $member['name'] : '';
                    $role = is_string($member['role'] ?? '') ? $member['role'] : '';
                    $bio = is_string($member['bio'] ?? '') ? $member['bio'] : '';
                    $image = is_string($member['image'] ?? '') ? $member['image'] : '';
                    
                    $localizedTeam[] = [
                        'name' => __($name, [], $locale),
                        'role' => __($role, [], $locale),
                        'bio' => __($bio, [], $locale),
                        'image' => $image,
                    ];
                }

                return $localizedTeam;
            }
        );
    }

    /**
     * Get cached FAQ with locale-specific translations grouped by category.
     *
     * @param string $locale
     * @return array<string, array<string, mixed>>
     */
    public function getFAQLocalized(string $locale): array
    {
        /** @var array<string, array<string, mixed>> */
        return Cache::remember(
            self::LOCALE_PREFIX . $locale . ':faq',
            self::CACHE_TTL,
            function () use ($locale): array {
                $faqConfig = Config::get('practice.faq', []);
                if (!is_array($faqConfig)) {
                    return [];
                }
                
                /** @var array<string, array<string, mixed>> $groupedFAQ */
                $groupedFAQ = [];

                foreach ($faqConfig as $item) {
                    if (!is_array($item)) {
                        continue;
                    }
                    
                    $category = is_string($item['category'] ?? '') ? $item['category'] : '';
                    $question = is_string($item['question'] ?? '') ? $item['question'] : '';
                    $answer = is_string($item['answer'] ?? '') ? $item['answer'] : '';
                    $sortOrder = is_numeric($item['sort_order'] ?? 0) ? (int)$item['sort_order'] : 0;
                    
                    $categoryKey = __($category, [], $locale);
                    $categoryKeyString = is_string($categoryKey) ? $categoryKey : $category;
                    
                    if (!isset($groupedFAQ[$categoryKeyString])) {
                        $groupedFAQ[$categoryKeyString] = [
                            'category' => $categoryKeyString,
                            'questions' => [],
                        ];
                    }

                    $groupedFAQ[$categoryKeyString]['questions'][] = [
                        'question' => __($question, [], $locale),
                        'answer' => __($answer, [], $locale),
                        'sort_order' => $sortOrder,
                    ];
                }

                // Sort questions within each category by sort_order
                foreach ($groupedFAQ as &$category) {
                    if (isset($category['questions']) && is_array($category['questions'])) {
                        usort($category['questions'], function (mixed $a, mixed $b): int {
                            if (!is_array($a) || !is_array($b)) {
                                return 0;
                            }
                            $sortA = is_numeric($a['sort_order'] ?? 0) ? (int)$a['sort_order'] : 0;
                            $sortB = is_numeric($b['sort_order'] ?? 0) ? (int)$b['sort_order'] : 0;
                            return $sortA <=> $sortB;
                        });
                    }
                }

                return $groupedFAQ;
            }
        );
    }


    /**
     * Get opening hours with locale-specific caching.
     *
     * @param string $locale
     * @return array<string, string>
     */
    public function getOpeningHours(string $locale): array
    {
        /** @var array<string, string> */
        return Cache::remember(
            self::LOCALE_PREFIX . $locale . ':opening_hours',
            self::CACHE_TTL,
            function () use ($locale): array {
                // Cache translated opening hours
                return [
                    'monday_friday' => __('messages.opening_hours.monday_friday', [], $locale),
                    'time_mf' => __('messages.opening_hours.time_mf', [], $locale),
                    'saturday' => __('messages.opening_hours.saturday', [], $locale),
                    'time_sat' => __('messages.opening_hours.time_sat', [], $locale),
                    'sunday' => __('messages.opening_hours.sunday', [], $locale),
                    'closed' => __('messages.opening_hours.closed', [], $locale),
                ];
            }
        );
    }

    /**
     * Get navigation items with locale-specific caching.
     *
     * @param string $locale
     * @return array<string, string>
     */
    public function getNavigationItems(string $locale): array
    {
        /** @var array<string, string> */
        return Cache::remember(
            self::LOCALE_PREFIX . $locale . ':navigation',
            self::CACHE_TTL,
            function () use ($locale): array {
                return [
                    'home' => __('messages.nav.home', [], $locale),
                    'services' => __('messages.nav.services', [], $locale),
                    'team' => __('messages.nav.team', [], $locale),
                    'events' => __('messages.nav.events', [], $locale),
                    'contact' => __('messages.nav.contact', [], $locale),
                    'book_appointment' => __('messages.nav.book_appointment', [], $locale),
                ];
            }
        );
    }

    /**
     * Cache a service card HTML fragment.
     *
     * @param array<string, string> $service
     * @param string $locale
     * @return string
     */
    public function getServiceCardHtml(array $service, string $locale): string
    {
        $cacheKey = self::PRACTICE_PREFIX . 'service_card:' . md5(serialize($service)) . ':' . $locale;
        
        /** @var string */
        return Cache::remember(
            $cacheKey,
            self::CACHE_TTL,
            function () use ($service): string {
                try {
                    // Check if view exists before rendering
                    if (!view()->exists('components.service-card')) {
                        return '';
                    }
                    /** @var \Illuminate\Contracts\View\View $view */
                    $view = view('components.service-card', compact('service'));
                    return $view->render();
                } catch (\Exception) {
                    return '';
                }
            }
        );
    }

    /**
     * Cache a team member card HTML fragment.
     *
     * @param array<string, string> $member
     * @param string $locale
     * @return string
     */
    public function getTeamMemberCardHtml(array $member, string $locale): string
    {
        $cacheKey = self::PRACTICE_PREFIX . 'team_card:' . md5(serialize($member)) . ':' . $locale;
        
        /** @var string */
        return Cache::remember(
            $cacheKey,
            self::CACHE_TTL,
            function () use ($member): string {
                try {
                    // Check if view exists before rendering
                    if (!view()->exists('components.team-member-card')) {
                        return '';
                    }
                    /** @var \Illuminate\Contracts\View\View $view */
                    $view = view('components.team-member-card', compact('member'));
                    return $view->render();
                } catch (\Exception) {
                    return '';
                }
            }
        );
    }

    /**
     * Invalidate all practice-related cache.
     *
     * @return void
     */
    public function invalidatePracticeCache(): void
    {
        // Get all cache keys with practice prefix
        $keys = [
            self::PRACTICE_PREFIX . 'services',
            self::PRACTICE_PREFIX . 'team',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Invalidate locale-specific cache.
     *
     * @param string $locale
     * @return void
     */
    public function invalidateLocaleCache(string $locale): void
    {
        $keys = [
            self::LOCALE_PREFIX . $locale . ':opening_hours',
            self::LOCALE_PREFIX . $locale . ':navigation',
            self::LOCALE_PREFIX . $locale . ':team',
            self::LOCALE_PREFIX . $locale . ':faq',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Warm up cache with frequently accessed content.
     *
     * @return void
     */
    public function warmCache(): void
    {
        // Warm practice content
        $this->getPracticeServices();
        $this->getPracticeTeam();

        // Warm locale-specific content for supported locales
        $locales = ['de', 'en'];
        foreach ($locales as $locale) {
            $this->getOpeningHours($locale);
            $this->getNavigationItems($locale);
            $this->getPracticeTeamLocalized($locale);
            $this->getFAQLocalized($locale);
        }
    }

    /**
     * Get cache statistics for monitoring.
     *
     * @return array<string, mixed>
     */
    public function getCacheStats(): array
    {
        $keys = [
            'practice_services' => self::PRACTICE_PREFIX . 'services',
            'practice_team' => self::PRACTICE_PREFIX . 'team',
        ];

        $stats = [];
        foreach ($keys as $name => $key) {
            $stats[$name] = Cache::has($key);
        }

        return $stats;
    }
}