<?php

namespace App\Contracts;

use App\DTO\ContactFormData;
use App\Models\FormRequest;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface for contact form processing services.
 * 
 * Following Interface Segregation Principle - only methods
 * needed for contact form processing.
 */
interface ContactFormServiceInterface
{
    /**
     * Process a contact form submission.
     * 
     * Note: Locale detection is handled by middleware,
     * so no request parameter needed.
     * 
     * @throws \Throwable
     */
    public function processContactForm(ContactFormData $data): FormRequest;

    /**
     * Get recent form requests for admin purposes.
     * 
     * @return Collection<int, FormRequest>
     */
    public function getRecentRequests(int $limit = 50): Collection;

    /**
     * Get form request statistics.
     *
     * @return array<string, int>
     */
    public function getStatistics(): array;
}