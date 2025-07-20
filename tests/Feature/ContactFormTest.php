<?php

namespace Tests\Feature;

use App\DTO\ContactFormData;
use App\Models\ContactReason;
use App\Models\FormRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private ContactReason $contactReason;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test contact reason
        $this->contactReason = ContactReason::factory()->create([
            'key' => 'general_inquiry',
            'name' => json_encode([
                'de' => 'Allgemeine Anfrage',
                'en' => 'General Inquiry'
            ]),
            'is_active' => true,
        ]);
    }

    public function test_contact_form_page_loads_successfully(): void
    {
        $response = $this->get(route('contact'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.contact');
    }

    public function test_contact_form_submission_with_minimal_required_data(): void
    {
        Mail::fake();

        $formData = [
            'full_name' => 'Maria Mustermann',
            'email' => 'maria@example.com',
            'contact_reason_id' => $this->contactReason->id,
        ];

        $response = $this->post(route('form.request.submit'), $formData);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');

        // Assert database record was created
        $this->assertDatabaseHas('form_requests', [
            'full_name' => 'Maria Mustermann',
            'email' => 'maria@example.com',
            'contact_reason_id' => $this->contactReason->id,
            'phone' => null,
            'preferred_datetime' => null,
            'message' => null,
        ]);

        // Assert email was sent
        Mail::assertQueued(\App\Mail\RequestSubmittedMailable::class);
    }

    public function test_contact_form_submission_with_complete_data(): void
    {
        Mail::fake();

        $preferredDateTime = now()->addDays(3)->format('Y-m-d H:i:s');

        $formData = [
            'full_name' => 'Hans Müller',
            'email' => 'hans.mueller@example.de',
            'phone' => '+49 30 12345678',
            'preferred_datetime' => $preferredDateTime,
            'message' => 'Ich hätte gerne einen Termin für eine Vorsorgeuntersuchung.',
            'contact_reason_id' => $this->contactReason->id,
        ];

        $response = $this->post(route('form.request.submit'), $formData);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');

        // Assert database record was created with all data
        $this->assertDatabaseHas('form_requests', [
            'full_name' => 'Hans Müller',
            'email' => 'hans.mueller@example.de',
            'phone' => '+49 30 12345678',
            'message' => 'Ich hätte gerne einen Termin für eine Vorsorgeuntersuchung.',
            'contact_reason_id' => $this->contactReason->id,
        ]);

        // Assert email was sent
        Mail::assertQueued(\App\Mail\RequestSubmittedMailable::class);
    }

    public function test_contact_form_validation_requires_full_name(): void
    {
        $formData = [
            'email' => 'test@example.com',
            'contact_reason_id' => $this->contactReason->id,
        ];

        $response = $this->post(route('form.request.submit'), $formData);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHasErrors(['full_name']);
        $this->assertDatabaseCount('form_requests', 0);
    }

    public function test_contact_form_validation_requires_valid_email(): void
    {
        $formData = [
            'full_name' => 'Test User',
            'email' => 'invalid-email',
            'contact_reason_id' => $this->contactReason->id,
        ];

        $response = $this->post(route('form.request.submit'), $formData);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseCount('form_requests', 0);
    }

    public function test_contact_form_validation_requires_existing_contact_reason(): void
    {
        $formData = [
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'contact_reason_id' => 999999, // Non-existent ID
        ];

        $response = $this->post(route('form.request.submit'), $formData);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHasErrors(['contact_reason_id']);
        $this->assertDatabaseCount('form_requests', 0);
    }

    public function test_contact_form_validation_rejects_inactive_contact_reason(): void
    {
        // Create inactive contact reason
        $inactiveReason = ContactReason::factory()->create([
            'is_active' => false,
        ]);

        $formData = [
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'contact_reason_id' => $inactiveReason->id,
        ];

        $response = $this->post(route('form.request.submit'), $formData);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHasErrors(['contact_reason_id']);
        $this->assertDatabaseCount('form_requests', 0);
    }

    public function test_contact_form_validation_rejects_past_preferred_datetime(): void
    {
        $pastDateTime = now()->subHour()->format('Y-m-d H:i:s');

        $formData = [
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'preferred_datetime' => $pastDateTime,
            'contact_reason_id' => $this->contactReason->id,
        ];

        $response = $this->post(route('form.request.submit'), $formData);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHasErrors(['preferred_datetime']);
        $this->assertDatabaseCount('form_requests', 0);
    }

    public function test_contact_form_validation_limits_message_length(): void
    {
        $longMessage = str_repeat('A', 1001); // Over 1000 character limit

        $formData = [
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'message' => $longMessage,
            'contact_reason_id' => $this->contactReason->id,
        ];

        $response = $this->post(route('form.request.submit'), $formData);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHasErrors(['message']);
        $this->assertDatabaseCount('form_requests', 0);
    }

    public function test_contact_form_validates_phone_number_length(): void
    {
        $longPhone = str_repeat('1', 51); // Over 50 character limit

        $formData = [
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => $longPhone,
            'contact_reason_id' => $this->contactReason->id,
        ];

        $response = $this->post(route('form.request.submit'), $formData);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHasErrors(['phone']);
        $this->assertDatabaseCount('form_requests', 0);
    }

    public function test_contact_form_preserves_input_on_validation_error(): void
    {
        $formData = [
            'full_name' => 'Test User',
            'email' => 'invalid-email',
            'phone' => '+49 30 12345678',
            'message' => 'This should be preserved',
            'contact_reason_id' => $this->contactReason->id,
        ];

        $response = $this->post(route('form.request.submit'), $formData);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHasInput(['full_name', 'phone', 'message']);
    }

    public function test_contact_form_handles_service_exceptions_gracefully(): void
    {
        Mail::fake();

        // Mock the service to throw an exception
        $this->mock(\App\Contracts\ContactFormServiceInterface::class, function ($mock) {
            $mock->shouldReceive('processContactForm')
                ->andThrow(new \Exception('Database connection failed'));
        });

        $formData = [
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'contact_reason_id' => $this->contactReason->id,
        ];

        $response = $this->post(route('form.request.submit'), $formData);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('error');
        $response->assertSessionHasInput(['full_name', 'email', 'contact_reason_id']);
    }

    public function test_contact_form_logs_successful_submissions(): void
    {
        Mail::fake();
        Log::fake();

        $formData = [
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'contact_reason_id' => $this->contactReason->id,
        ];

        $this->post(route('form.request.submit'), $formData);

        Log::assertLogged('info', function ($message, $context) {
            return $message === 'Contact form submitted successfully' &&
                isset($context['request_id']) &&
                $context['email'] === 'test@example.com';
        });
    }

    public function test_contact_form_logs_submission_failures(): void
    {
        Log::fake();

        // Mock the service to throw an exception
        $this->mock(\App\Contracts\ContactFormServiceInterface::class, function ($mock) {
            $mock->shouldReceive('processContactForm')
                ->andThrow(new \Exception('Test exception'));
        });

        $formData = [
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'contact_reason_id' => $this->contactReason->id,
        ];

        $this->post(route('form.request.submit'), $formData);

        Log::assertLogged('error', function ($message, $context) {
            return $message === 'Contact form submission failed' &&
                $context['error'] === 'Test exception';
        });
    }

    public function test_contact_form_data_transfer_object_creation(): void
    {
        $preferredDateTime = now()->addDays(2);

        $data = [
            'full_name' => 'Anna Schmidt',
            'email' => 'anna@example.com',
            'phone' => '+49 40 987654321',
            'preferred_datetime' => $preferredDateTime->toDateTimeString(),
            'message' => 'Test message',
            'contact_reason_id' => $this->contactReason->id,
        ];

        $dto = ContactFormData::fromArray($data);

        $this->assertEquals('Anna Schmidt', $dto->fullName);
        $this->assertEquals('anna@example.com', $dto->email);
        $this->assertEquals('+49 40 987654321', $dto->phone);
        $this->assertEquals('Test message', $dto->message);
        $this->assertTrue($dto->preferredDatetime->eq($preferredDateTime));
        $this->assertEquals($this->contactReason->id, $dto->contactReason->id);
    }

    public function test_contact_form_works_with_different_locales(): void
    {
        Mail::fake();

        // Test with German locale
        app()->setLocale('de');

        $formData = [
            'full_name' => 'Klaus Weber',
            'email' => 'klaus@example.de',
            'contact_reason_id' => $this->contactReason->id,
        ];

        $response = $this->post(route('form.request.submit'), $formData);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');

        // Test with English locale
        app()->setLocale('en');

        $formData['email'] = 'klaus-en@example.com';
        $response = $this->post(route('form.request.submit'), $formData);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('form_requests', 2);
    }

    public function test_contact_form_csrf_protection(): void
    {
        $formData = [
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'contact_reason_id' => $this->contactReason->id,
        ];

        // Verify CSRF protection is in place by checking middleware configuration
        $middleware = app()->make(\Illuminate\Foundation\Http\Kernel::class)->getMiddlewareGroups();

        $this->assertArrayHasKey('web', $middleware);
        $this->assertContains(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class, $middleware['web']);
    }
}
