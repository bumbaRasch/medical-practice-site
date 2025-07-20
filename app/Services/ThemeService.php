<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Theme;

/**
 * Theme Management Service
 * Handles theme detection, persistence, and state management for dark/light mode
 */
final class ThemeService
{
    private const SESSION_KEY = 'theme_preference';
    private const COOKIE_NAME = 'theme_preference';
    // Constant is intentionally not used to maintain future API compatibility

    public function __construct()
    {
        // Initialize theme on service creation
        $this->initializeTheme();
    }

    /**
     * Get the current theme based on user preference hierarchy
     */
    public function getCurrentTheme(): Theme
    {
        // 1. Check session for manual selection (highest priority)
        if (session()->has(self::SESSION_KEY)) {
            $sessionTheme = session(self::SESSION_KEY);
            if ($this->isValidTheme($sessionTheme)) {
                /** @var string $sessionTheme */
                return Theme::from($sessionTheme);
            }
        }

        // 2. Check cookie for persistent preference
        if (request()->hasCookie(self::COOKIE_NAME)) {
            $cookieTheme = request()->cookie(self::COOKIE_NAME);
            if ($this->isValidTheme($cookieTheme)) {
                /** @var string $cookieTheme */
                // Sync session with cookie
                session([self::SESSION_KEY => $cookieTheme]);
                return Theme::from($cookieTheme);
            }
        }

        // 3. Default to light theme (system preference handled in JavaScript)
        return Theme::LIGHT;
    }

    /**
     * Set user theme preference with persistence
     */
    public function setTheme(Theme $theme): void
    {
        // Store in session for immediate use
        session([self::SESSION_KEY => $theme->value]);

        // Store in cookie for persistence across sessions (1 year)
        cookie()->queue(
            self::COOKIE_NAME,
            $theme->value,
            60 * 24 * 365, // 1 year in minutes
            secure: request()->isSecure(),
            sameSite: 'strict'
        );
    }

    /**
     * Toggle between light and dark themes
     */
    public function toggleTheme(): Theme
    {
        $currentTheme = $this->getCurrentTheme();
        $newTheme = $currentTheme === Theme::LIGHT ? Theme::DARK : Theme::LIGHT;
        
        $this->setTheme($newTheme);
        return $newTheme;
    }

    /**
     * Get theme data for JavaScript initialization
     * 
     * @return array<string, mixed>
     */
    public function getThemeData(): array
    {
        $currentTheme = $this->getCurrentTheme();
        
        return [
            'current' => $currentTheme->value,
            'available' => array_map(fn(Theme $theme) => [
                'value' => $theme->value,
                'name' => $theme->getDisplayName(),
                'icon' => $theme->getIcon(),
            ], Theme::cases()),
            'meta_colors' => [
                'light' => '#3B7BB8',
                'dark' => '#0f172a',
            ],
            'session_key' => self::SESSION_KEY,
            'cookie_name' => self::COOKIE_NAME,
            'session_preference' => session()->has(self::SESSION_KEY),
            'has_manual_preference' => session()->has(self::SESSION_KEY) || request()->hasCookie(self::COOKIE_NAME),
        ];
    }

    /**
     * Check if theme preference should be detected from system
     */
    public function shouldDetectSystemPreference(): bool
    {
        // Only detect system preference if no manual preference is set
        return !session()->has(self::SESSION_KEY) && 
               !request()->hasCookie(self::COOKIE_NAME);
    }

    /**
     * Get CSS class for current theme
     */
    public function getThemeClass(): string
    {
        return $this->getCurrentTheme() === Theme::DARK ? 'dark' : '';
    }

    /**
     * Get appropriate meta theme-color for current theme
     */
    public function getMetaThemeColor(): string
    {
        return match ($this->getCurrentTheme()) {
            Theme::DARK => '#0f172a',
            Theme::LIGHT => '#3B7BB8',
        };
    }

    /**
     * Get theme-specific favicon if available
     */
    public function getFaviconPath(): string
    {
        return match ($this->getCurrentTheme()) {
            Theme::DARK => asset('favicon-dark.ico'),
            Theme::LIGHT => asset('favicon.ico'),
        };
    }

    /**
     * Initialize theme on service creation
     */
    private function initializeTheme(): void
    {
        // Clean up any conflicting session keys
        if (session()->has('user_theme_preference')) {
            $oldTheme = session('user_theme_preference');
            if ($this->isValidTheme($oldTheme)) {
                session([self::SESSION_KEY => $oldTheme]);
            }
            session()->forget('user_theme_preference');
        }
        
        // Ensure we have a valid theme set
        $currentTheme = $this->getCurrentTheme();
        
        // If no session theme is set, initialize with current theme
        if (!session()->has(self::SESSION_KEY)) {
            session([self::SESSION_KEY => $currentTheme->value]);
        }
    }

    /**
     * Validate if theme value is supported
     */
    private function isValidTheme(mixed $theme): bool
    {
        if (!is_string($theme)) {
            return false;
        }

        return in_array($theme, array_map(fn(Theme $t) => $t->value, Theme::cases()), true);
    }

    /**
     * Get theme preference from multiple sources for debugging
     * 
     * @return array<string, mixed>
     */
    public function getThemeDebugInfo(): array
    {
        return [
            'current_theme' => $this->getCurrentTheme()->value,
            'session_theme' => session(self::SESSION_KEY),
            'cookie_theme' => request()->cookie(self::COOKIE_NAME),
            'should_detect_system' => $this->shouldDetectSystemPreference(),
            'theme_class' => $this->getThemeClass(),
            'meta_color' => $this->getMetaThemeColor(),
        ];
    }
}