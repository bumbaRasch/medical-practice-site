<?php

namespace App\Enums;

/**
 * Enum for supported application locales.
 * 
 * Provides centralized management of supported languages with metadata.
 */
enum Locale: string
{
    case GERMAN = 'de';
    case ENGLISH = 'en';

    /**
     * Get the native name of the language.
     */
    public function nativeName(): string
    {
        return match($this) {
            self::GERMAN => 'Deutsch',
            self::ENGLISH => 'English',
        };
    }

    /**
     * Get the English name of the language.
     */
    public function englishName(): string
    {
        return match($this) {
            self::GERMAN => 'German',
            self::ENGLISH => 'English',
        };
    }

    /**
     * Get the flag emoji for the language.
     */
    public function flag(): string
    {
        return match($this) {
            self::GERMAN => '🇩🇪',
            self::ENGLISH => '🇺🇸',
        };
    }

    /**
     * Get the short language code for display.
     */
    public function shortCode(): string
    {
        return match($this) {
            self::GERMAN => 'DE',
            self::ENGLISH => 'EN',
        };
    }

    /**
     * Get the locale code.
     */
    public function code(): string
    {
        return $this->value;
    }

    /**
     * Check if this is the default locale.
     */
    public function isDefault(): bool
    {
        return $this === self::GERMAN;
    }

    /**
     * Get all supported locale codes.
     *
     * @return array<string>
     */
    public static function supportedCodes(): array
    {
        return array_map(fn(self $locale) => $locale->value, self::cases());
    }

    /**
     * Get all locales as options for dropdowns.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $locale) {
            $options[$locale->value] = $locale->nativeName();
        }
        return $options;
    }

    /**
     * Get all locales as options with flags.
     *
     * @return array<string, string>
     */
    public static function optionsWithFlags(): array
    {
        $options = [];
        foreach (self::cases() as $locale) {
            $options[$locale->value] = $locale->flag() . ' ' . $locale->nativeName();
        }
        return $options;
    }

    /**
     * Create from string value, with validation.
     */
    public static function fromString(string $value): ?self
    {
        return self::tryFrom($value);
    }

    /**
     * Get the default locale.
     */
    public static function default(): self
    {
        return self::GERMAN;
    }

    /**
     * Check if a locale code is supported.
     */
    public static function isSupported(string $code): bool
    {
        return self::tryFrom($code) !== null;
    }

    /**
     * Get the first supported locale from an array of preferences.
     *
     * @param array<string> $preferences
     */
    public static function getPreferred(array $preferences): self
    {
        foreach ($preferences as $preference) {
            $locale = self::tryFrom($preference);
            if ($locale !== null) {
                return $locale;
            }
        }
        
        return self::default();
    }
}