<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Theme enumeration for dark/light mode support
 */
enum Theme: string
{
    case LIGHT = 'light';
    case DARK = 'dark';

    /**
     * Get display name for the theme
     */
    public function getDisplayName(): string
    {
        return match ($this) {
            self::LIGHT => __('messages.theme.light'),
            self::DARK => __('messages.theme.dark'),
        };
    }

    /**
     * Get icon for the theme
     */
    public function getIcon(): string
    {
        return match ($this) {
            self::LIGHT => 'sun',
            self::DARK => 'moon',
        };
    }

    /**
     * Get SVG icon for the theme
     */
    public function getSvgIcon(): string
    {
        return match ($this) {
            self::LIGHT => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>',
            self::DARK => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>',
        };
    }

    /**
     * Get opposite theme
     */
    public function getOpposite(): self
    {
        return match ($this) {
            self::LIGHT => self::DARK,
            self::DARK => self::LIGHT,
        };
    }

    /**
     * Get CSS class for the theme
     */
    public function getCssClass(): string
    {
        return match ($this) {
            self::LIGHT => '',
            self::DARK => 'dark',
        };
    }

    /**
     * Get meta theme color for the theme
     */
    public function getMetaThemeColor(): string
    {
        return match ($this) {
            self::LIGHT => '#3B7BB8',
            self::DARK => '#0f172a',
        };
    }

    /**
     * Check if theme is dark
     */
    public function isDark(): bool
    {
        return $this === self::DARK;
    }

    /**
     * Check if theme is light
     */
    public function isLight(): bool
    {
        return $this === self::LIGHT;
    }

    /**
     * Get all theme cases with display data
     * 
     * @return array<int, array<string, mixed>>
     */
    public static function getAllWithData(): array
    {
        return array_map(fn(self $theme) => [
            'value' => $theme->value,
            'name' => $theme->getDisplayName(),
            'icon' => $theme->getIcon(),
            'svg' => $theme->getSvgIcon(),
            'css_class' => $theme->getCssClass(),
            'meta_color' => $theme->getMetaThemeColor(),
        ], self::cases());
    }
}