<?php

namespace App\Http\Controllers;

use App\DTO\ContactFormData;
use App\Http\Requests\ContactFormRequest;
use App\Contracts\ContactFormServiceInterface;
use Illuminate\Http\RedirectResponse;
use App\Logging\MedicalLogger;
use Throwable;

class FormRequestController extends Controller
{
    public function __construct(
        private readonly ContactFormServiceInterface $contactFormService,
    ) {}

    /**
     * Handle contact form submission.
     */
    public function submit(ContactFormRequest $request): RedirectResponse
    {
        try {
            // Create DTO from validated data
            $contactData = ContactFormData::fromArray($request->validated());

            // Process through service (locale already set by middleware)
            $formRequest = $this->contactFormService->processContactForm($contactData);

            // Log successful submission with structured logging
            MedicalLogger::userAction('contact_form_submitted', [
                'request_id' => $formRequest->id,
                'form_completion_time' => 'immediate', // Could be enhanced with timing
                'user_type' => 'patient',
                'submission_method' => 'web_form',
            ]);

            return redirect()
                ->route('contact')
                ->with('success', __('messages.contact.form_success'));

        } catch (Throwable $e) {
            // Log error with structured logging
            MedicalLogger::contactFormFailed(
                $e->getMessage(),
                $request->safe()->except(['_token']),
                [
                    'error_type' => get_class($e),
                    'user_type' => 'patient',
                    'submission_method' => 'web_form',
                    'form_data_preserved' => true,
                    'user_impact' => 'form_resubmission_required',
                ]
            );

            // Log as security event if it's a system error
            if (!($e instanceof \Illuminate\Validation\ValidationException)) {
                MedicalLogger::securityEvent(
                    'contact_form_system_error',
                    'error',
                    [
                        'error_class' => get_class($e),
                        'user_impact' => 'service_disruption',
                    ]
                );
            }

            return redirect()
                ->route('contact')
                ->withInput()
                ->with('error', __('messages.contact.form_error'));
        }
    }
}
