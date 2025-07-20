<?php

namespace App\Enums;

/**
 * Enum for contact form reasons.
 * 
 * Provides predefined options for why users are contacting the practice.
 */
enum ContactReason: string
{
    case APPOINTMENT = 'termin';
    case QUESTION = 'frage';
    case COMPLAINT = 'beschwerde';
    case EMERGENCY = 'notfall';
    case PRESCRIPTION = 'rezept';
    case REFERRAL = 'ueberweisung';
    case CONSULTATION = 'beratung';
    case OTHER = 'sonstiges';

    /**
     * Get the localized label for the contact reason.
     */
    public function label(): string
    {
        return __('messages.contact_reasons.' . $this->value);
    }

    /**
     * Get all contact reasons as an array for form options.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }

    /**
     * Get the contact reason from a string value.
     */
    public static function fromString(string $value): ?self
    {
        return self::tryFrom($value);
    }
}