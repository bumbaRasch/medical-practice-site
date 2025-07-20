<?php

namespace App\Http\Services;

use App\Contracts\ContactFormServiceInterface;
use App\DTO\ContactFormData;
use App\Mail\RequestSubmittedMailable;
use App\Models\FormRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Logging\MedicalLogger;
use Throwable;

/**
 * Service class handling contact form business logic.
 * 
 * Follows Single Responsibility Principle by handling only
 * contact form processing logic.
 */
class ContactFormService implements ContactFormServiceInterface
{
    /**
     * Process a contact form submission.
     * 
     * This method:
     * 1. Persists the form data to database
     * 2. Sends notification email to practice
     * 
     * Note: Locale is already set by LocaleMiddleware,
     * so we just use App::getLocale().
     * 
     * @throws Throwable
     */
    public function processContactForm(ContactFormData $data): FormRequest
    {
        return DB::transaction(function () use ($data): FormRequest {
            // Step 1: Persist to database first (as per CLAUDE.md requirement)
            $formRequest = $this->saveFormRequest($data);

            // Step 2: Get current locale (set by middleware)
            $locale = App::getLocale();

            // Step 3: Send email notification with current locale
            $this->sendNotificationEmail($data, $formRequest, $locale);

            return $formRequest;
        });
    }

    /**
     * Save form request to database.
     */
    private function saveFormRequest(ContactFormData $data): FormRequest
    {
        $formRequest = FormRequest::create($data->toArray());

        // Use structured logging for medical practice context
        MedicalLogger::contactFormSubmitted(
            $formRequest->id,
            $data->email,
            [
                'has_preferred_datetime' => $data->hasPreferredDatetime(),
                'has_phone' => $data->hasPhone(),
                'has_message' => $data->hasMessage(),
                'contact_reason' => $data->contactReason->key ?? 'unknown',
                'locale' => App::getLocale(),
            ]
        );

        // Also log to audit trail for compliance
        MedicalLogger::auditEvent(
            'form_request_created',
            'contact_form',
            [
                'request_id' => $formRequest->id,
                'form_completion' => [
                    'required_fields' => 3, // name, email, reason
                    'optional_fields_completed' => (int)$data->hasPhone() + (int)$data->hasMessage() + (int)$data->hasPreferredDatetime(),
                ],
            ]
        );

        return $formRequest;
    }

    /**
     * Send notification email to practice.
     * 
     * Note: Uses current locale set by middleware.
     */
    private function sendNotificationEmail(ContactFormData $data, FormRequest $formRequest, string $locale): void
    {
        $practiceEmail = config('mail.practice_email');
        
        // Ensure we have a valid practice email
        if (!is_string($practiceEmail) || empty($practiceEmail)) {
            throw new \InvalidArgumentException('Practice email not configured properly');
        }
        
        try {
            // Use the locale already set by middleware
            Mail::to($practiceEmail)
                ->send(new RequestSubmittedMailable($data, $formRequest));

            // Use structured logging for email notifications
            MedicalLogger::emailNotification(
                'notification_sent',
                $practiceEmail,
                [
                    'request_id' => $formRequest->id,
                    'locale' => $locale,
                    'email_type' => 'contact_form_notification',
                    'recipient_type' => 'practice_staff',
                ]
            );
        } catch (Throwable $e) {
            // Use structured logging for email failures
            MedicalLogger::emailNotification(
                'notification_failed',
                $practiceEmail,
                [
                    'request_id' => $formRequest->id,
                    'error_message' => $e->getMessage(),
                    'error_type' => get_class($e),
                    'email_type' => 'contact_form_notification',
                    'impact' => 'practice_not_notified',
                    'data_safe' => true, // Form data was saved successfully
                ]
            );

            // Also log as security event if it's a recurring issue
            MedicalLogger::securityEvent(
                'email_delivery_failure',
                'warning',
                [
                    'service' => 'contact_form_notifications',
                    'impact' => 'patient_communication_delayed',
                ]
            );

            // Re-throw in development for debugging
            if (app()->environment('local')) {
                throw $e;
            }
        }
    }

    /**
     * Get recent form requests for admin purposes.
     * 
     * @return \Illuminate\Database\Eloquent\Collection<int, FormRequest>
     */
    public function getRecentRequests(int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return FormRequest::latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get form request statistics.
     *
     * @return array<string, int>
     */
    public function getStatistics(): array
    {
        return [
            'total_requests' => FormRequest::count(),
            'requests_today' => FormRequest::whereDate('created_at', today())->count(),
            'requests_this_week' => FormRequest::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])->count(),
            'requests_this_month' => FormRequest::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
    }
}