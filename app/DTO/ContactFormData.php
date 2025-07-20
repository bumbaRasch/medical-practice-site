<?php

namespace App\DTO;

use App\Models\ContactReason;
use Carbon\Carbon;

/**
 * Data Transfer Object for contact form data.
 * 
 * Represents validated contact form submission data
 * in a type-safe, immutable structure.
 */
readonly class ContactFormData
{
    public function __construct(
        public string $fullName,
        public string $email,
        public ?string $phone,
        public ?Carbon $preferredDatetime,
        public ?string $message,
        public ContactReason $contactReason,
    ) {}

    /**
     * Create ContactFormData from validated request data.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $fullName = $data['full_name'] ?? '';
        $email = $data['email'] ?? '';
        $contactReasonId = $data['contact_reason_id'] ?? null;
        
        if (!is_string($fullName) || empty($fullName)) {
            throw new \InvalidArgumentException('Full name must be a non-empty string');
        }
        
        if (!is_string($email) || empty($email)) {
            throw new \InvalidArgumentException('Email must be a non-empty string');
        }
        
        if (!is_numeric($contactReasonId)) {
            throw new \InvalidArgumentException('Contact reason ID must be numeric');
        }
        
        $contactReason = ContactReason::find((int) $contactReasonId);
        if (!$contactReason) {
            throw new \InvalidArgumentException('Invalid contact reason provided');
        }
        
        $phone = isset($data['phone']) && is_string($data['phone']) && !empty(trim($data['phone'])) 
            ? trim($data['phone']) 
            : null;
            
        $message = isset($data['message']) && is_string($data['message']) && !empty(trim($data['message'])) 
            ? trim($data['message']) 
            : null;
        
        $preferredDatetime = null;
        if (isset($data['preferred_datetime']) && is_string($data['preferred_datetime']) && !empty($data['preferred_datetime'])) {
            try {
                $preferredDatetime = Carbon::parse($data['preferred_datetime']);
            } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                throw new \InvalidArgumentException('Invalid preferred datetime format', 0, $e);
            }
        }
        
        return new self(
            fullName: trim($fullName),
            email: trim($email),
            phone: $phone,
            preferredDatetime: $preferredDatetime,
            message: $message,
            contactReason: $contactReason,
        );
    }

    /**
     * Convert to array format suitable for database storage.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'full_name' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'preferred_datetime' => $this->preferredDatetime?->toDateTimeString(),
            'message' => $this->message,
            'contact_reason_id' => $this->contactReason->id,
        ];
    }

    /**
     * Check if the request has a preferred appointment time.
     */
    public function hasPreferredDatetime(): bool
    {
        return $this->preferredDatetime !== null;
    }

    /**
     * Check if the request includes a phone number.
     */
    public function hasPhone(): bool
    {
        return $this->phone !== null && trim($this->phone) !== '';
    }

    /**
     * Check if the request includes a message.
     */
    public function hasMessage(): bool
    {
        return $this->message !== null && trim($this->message) !== '';
    }

    /**
     * Get formatted preferred datetime for display.
     */
    public function getFormattedPreferredDatetime(): ?string
    {
        return $this->preferredDatetime?->format('d.m.Y H:i');
    }
}