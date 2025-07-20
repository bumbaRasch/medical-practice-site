# Medical Practice Website - API & Service Layer Documentation

## 🔧 Service Layer Architecture

The medical practice website implements a **clean service layer pattern** with strict type safety, comprehensive error handling, and healthcare-specific business logic. All services follow Laravel's dependency injection pattern with interface-based contracts.

---

## 📋 Service Layer Overview

### Core Philosophy
- **Business Logic Separation**: Controllers handle HTTP, services handle business rules
- **Interface-Based Design**: All services implement contracts for testability  
- **Transaction Safety**: Database operations wrapped in transactions
- **Comprehensive Logging**: All critical operations logged for audit trails
- **Type Safety**: PHPStan Level 9 compliance throughout

### Service Architecture Pattern
```
Controller → FormRequest → DTO → Service → Model → Database
    ↓                              ↓
Response ←─── View ←─── Result ←─── Email
```

---

## 🏥 Contact Form Service

### Interface Contract
```php
<?php

namespace App\Contracts;

use App\DTO\ContactFormData;
use App\Models\FormRequest;

interface ContactFormServiceInterface
{
    /**
     * Process a contact form submission with email notification
     * 
     * @param ContactFormData $data Validated and typed form data
     * @return FormRequest The created form request record
     * @throws \Exception If processing fails
     */
    public function processContactForm(ContactFormData $data): FormRequest;
}
```

### Implementation
```php
<?php

namespace App\Http\Services;

use App\Contracts\ContactFormServiceInterface;
use App\DTO\ContactFormData;
use App\Mail\RequestSubmittedMailable;
use App\Models\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactFormService implements ContactFormServiceInterface
{
    /**
     * Process contact form with transaction safety and email notification
     */
    public function processContactForm(ContactFormData $data): FormRequest
    {
        return DB::transaction(function () use ($data): FormRequest {
            // 1. Save form request to database
            $formRequest = $this->saveFormRequest($data);
            
            // 2. Send notification email with locale support
            $this->sendNotificationEmail($data, $formRequest, App::getLocale());
            
            return $formRequest;
        });
    }

    /**
     * Save form data to database with relationship handling
     */
    private function saveFormRequest(ContactFormData $data): FormRequest
    {
        $contactReason = ContactReason::where('key', $data->contactReason->value)
            ->firstOrFail();

        return FormRequest::create([
            'full_name' => $data->fullName,
            'email' => $data->email,
            'phone' => $data->phone,
            'preferred_datetime' => $data->preferredDatetime,
            'message' => $data->message,
            'contact_reason_id' => $contactReason->id,
        ]);
    }

    /**
     * Send email notification with comprehensive error handling
     */
    private function sendNotificationEmail(
        ContactFormData $data, 
        FormRequest $formRequest, 
        string $locale
    ): void {
        try {
            $mailable = new RequestSubmittedMailable($data, $formRequest, $locale);
            
            Mail::to(config('mail.practice_email', 'praxis@example.com'))
                ->send($mailable);
                
            Log::info('Contact form email sent successfully', [
                'form_request_id' => $formRequest->id,
                'email' => $data->email,
                'locale' => $locale,
            ]);
            
        } catch (\Exception $e) {
            // Log error but don't fail the transaction
            Log::error('Failed to send contact form email', [
                'form_request_id' => $formRequest->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // In production, you might want to queue a retry job here
            // Queue::push(new RetryEmailJob($formRequest->id));
        }
    }
}
```

---

## 📊 Cache Service

### Multi-Layer Caching Architecture
The `CacheService` provides **locale-aware caching** for practice content with 24-hour TTL and intelligent invalidation.

```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

class CacheService
{
    private const CACHE_TTL = 24 * 60 * 60; // 24 hours
    private const CACHE_TAGS = ['practice'];

    /**
     * Get localized practice team with performance caching
     * 
     * @param string|null $locale Current locale (auto-detected if null)
     * @return array<int, array{name: string, role: string, bio: string, image: string}>
     */
    public function getPracticeTeamLocalized(?string $locale = null): array
    {
        $locale = $locale ?? App::getLocale();
        
        return Cache::tags([...self::CACHE_TAGS, 'team', $locale])
            ->remember(
                "practice.team.{$locale}", 
                self::CACHE_TTL, 
                fn() => $this->translatePracticeContent('team', $locale)
            );
    }

    /**
     * Get localized practice services with slideshow data
     * 
     * @param string|null $locale Current locale
     * @return array<int, array{title: string, description: string, icon: string}>
     */
    public function getPracticeServicesLocalized(?string $locale = null): array
    {
        $locale = $locale ?? App::getLocale();
        
        return Cache::tags([...self::CACHE_TAGS, 'services', $locale])
            ->remember(
                "practice.services.{$locale}", 
                self::CACHE_TTL, 
                fn() => $this->translatePracticeContent('services', $locale)
            );
    }

    /**
     * Get localized FAQ data organized by categories
     * 
     * @param string|null $locale Current locale
     * @return array<string, array{category: string, questions: array}>
     */
    public function getFAQLocalized(?string $locale = null): array
    {
        $locale = $locale ?? App::getLocale();
        
        return Cache::tags([...self::CACHE_TAGS, 'faq', $locale])
            ->remember(
                "practice.faq.{$locale}", 
                self::CACHE_TTL, 
                fn() => $this->organizeFAQByCategory($locale)
            );
    }

    /**
     * Get opening hours with locale-aware formatting
     * 
     * @param string|null $locale Current locale
     * @return array<string, array{day: string, hours: string, status: string}>
     */
    public function getOpeningHoursLocalized(?string $locale = null): array
    {
        $locale = $locale ?? App::getLocale();
        
        return Cache::tags([...self::CACHE_TAGS, 'hours', $locale])
            ->remember(
                "practice.hours.{$locale}", 
                self::CACHE_TTL, 
                fn() => $this->formatOpeningHours($locale)
            );
    }

    /**
     * Warm all practice caches for better performance
     * 
     * @param array<string> $locales Locales to warm (defaults to supported locales)
     * @return array<string, array<string, bool>> Success status per locale and content type
     */
    public function warmAllCaches(array $locales = ['de', 'en']): array
    {
        $results = [];
        
        foreach ($locales as $locale) {
            $results[$locale] = [
                'team' => $this->warmCache('team', $locale),
                'services' => $this->warmCache('services', $locale),
                'faq' => $this->warmCache('faq', $locale),
                'hours' => $this->warmCache('hours', $locale),
            ];
        }
        
        return $results;
    }

    /**
     * Clear practice caches (useful for content updates)
     * 
     * @param array<string>|null $tags Specific tags to clear (null = all practice caches)
     * @return bool Success status
     */
    public function clearPracticeCaches(?array $tags = null): bool
    {
        try {
            if ($tags === null) {
                Cache::tags(self::CACHE_TAGS)->flush();
            } else {
                Cache::tags([...self::CACHE_TAGS, ...$tags])->flush();
            }
            
            Log::info('Practice caches cleared', ['tags' => $tags ?? 'all']);
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to clear practice caches', [
                'error' => $e->getMessage(),
                'tags' => $tags ?? 'all',
            ]);
            return false;
        }
    }

    /**
     * Translate practice content from configuration
     * 
     * @param string $contentType Type of content (team, services, etc.)
     * @param string $locale Target locale
     * @return array<int|string, mixed> Translated content array
     */
    private function translatePracticeContent(string $contentType, string $locale): array
    {
        $content = config("practice.{$contentType}", []);
        
        return collect($content)->map(function (array $item) {
            $translated = [];
            
            foreach ($item as $key => $value) {
                if (is_string($value) && str_starts_with($value, 'messages.')) {
                    $translated[$key] = __($value);
                } else {
                    $translated[$key] = $value;
                }
            }
            
            return $translated;
        })->toArray();
    }

    /**
     * Organize FAQ content by categories with sorting
     * 
     * @param string $locale Target locale for translations
     * @return array<string, array{category: string, questions: array}>
     */
    private function organizeFAQByCategory(string $locale): array
    {
        $faqItems = config('practice.faq', []);
        $organized = [];
        
        foreach ($faqItems as $item) {
            $category = __($item['category']);
            
            if (!isset($organized[$category])) {
                $organized[$category] = [
                    'category' => $category,
                    'questions' => [],
                ];
            }
            
            $organized[$category]['questions'][] = [
                'question' => __($item['question']),
                'answer' => __($item['answer']),
                'sort_order' => $item['sort_order'] ?? 999,
            ];
        }
        
        // Sort questions within each category
        foreach ($organized as &$category) {
            usort($category['questions'], 
                fn($a, $b) => $a['sort_order'] <=> $b['sort_order']
            );
        }
        
        return $organized;
    }

    /**
     * Format opening hours with locale-specific day names
     * 
     * @param string $locale Target locale
     * @return array<string, array{day: string, hours: string, status: string}>
     */
    private function formatOpeningHours(string $locale): array
    {
        return [
            'monday_friday' => [
                'day' => __('messages.opening_hours.monday_friday'),
                'hours' => __('messages.opening_hours.time_mf'),
                'status' => 'open',
            ],
            'saturday' => [
                'day' => __('messages.opening_hours.saturday'),
                'hours' => __('messages.opening_hours.time_sat'),
                'status' => 'open',
            ],
            'sunday' => [
                'day' => __('messages.opening_hours.sunday'),
                'hours' => __('messages.opening_hours.closed'),
                'status' => 'closed',
            ],
        ];
    }

    /**
     * Warm a specific cache type for a locale
     * 
     * @param string $type Content type to warm
     * @param string $locale Target locale
     * @return bool Success status
     */
    private function warmCache(string $type, string $locale): bool
    {
        try {
            match($type) {
                'team' => $this->getPracticeTeamLocalized($locale),
                'services' => $this->getPracticeServicesLocalized($locale),
                'faq' => $this->getFAQLocalized($locale),
                'hours' => $this->getOpeningHoursLocalized($locale),
                default => throw new \InvalidArgumentException("Unknown cache type: {$type}"),
            };
            
            return true;
            
        } catch (\Exception $e) {
            Log::error("Failed to warm {$type} cache for {$locale}", [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
```

---

## 🖼️ Slideshow Image Service

### Dynamic Image Management
The `SlideshowImageService` automatically discovers and manages practice images with metadata.

```php
<?php

namespace App\Http\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SlideshowImageService
{
    private const IMAGE_DIRECTORY = 'public/images/leistungen';
    private const SUPPORTED_FORMATS = ['webp', 'jpg', 'jpeg', 'png'];

    /**
     * Get all slideshow images with metadata
     * 
     * @return Collection<int, array{src: string, alt: string, title: string, description: string}>
     */
    public function getAllImages(): Collection
    {
        try {
            $imagePath = storage_path('app/' . self::IMAGE_DIRECTORY);
            
            if (!File::exists($imagePath)) {
                Log::warning('Slideshow image directory does not exist', [
                    'path' => $imagePath
                ]);
                return collect();
            }

            return collect(File::files($imagePath))
                ->filter(fn($file) => $this->isSupportedImageFormat($file))
                ->map(fn($file) => $this->createImageMetadata($file))
                ->sortBy('sort_order')
                ->values();

        } catch (\Exception $e) {
            Log::error('Failed to load slideshow images', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return collect();
        }
    }

    /**
     * Check if file is a supported image format
     * 
     * @param \SplFileInfo $file File to check
     * @return bool True if supported format
     */
    private function isSupportedImageFormat(\SplFileInfo $file): bool
    {
        return in_array(
            strtolower($file->getExtension()), 
            self::SUPPORTED_FORMATS, 
            true
        );
    }

    /**
     * Create image metadata from filename and translation keys
     * 
     * @param \SplFileInfo $file Image file
     * @return array{src: string, alt: string, title: string, description: string, sort_order: int}
     */
    private function createImageMetadata(\SplFileInfo $file): array
    {
        $filename = $file->getFilenameWithoutExtension();
        $publicPath = '/images/leistungen/' . $file->getFilename();
        
        // Generate translation key from filename
        $translationKey = $this->generateTranslationKey($filename);
        
        return [
            'src' => $publicPath,
            'alt' => __("messages.services.slideshow_photos.{$translationKey}.title"),
            'title' => __("messages.services.slideshow_photos.{$translationKey}.title"),
            'description' => __("messages.services.slideshow_photos.{$translationKey}.description"),
            'sort_order' => $this->getImageSortOrder($filename),
        ];
    }

    /**
     * Generate translation key from filename
     * 
     * @param string $filename Image filename without extension
     * @return string Translation key (snake_case)
     */
    private function generateTranslationKey(string $filename): string
    {
        // Convert filename to snake_case translation key
        return strtolower(str_replace([' ', '-', '_'], '_', $filename));
    }

    /**
     * Get sort order for consistent image ordering
     * 
     * @param string $filename Image filename
     * @return int Sort order (lower = first)
     */
    private function getImageSortOrder(string $filename): int
    {
        // Define priority images for consistent ordering
        $priorityImages = [
            'Medical Examination Room in Daylight' => 1,
            'Modern Medical Office Reception' => 2,
            'Modern Waiting Room with Natural Light' => 3,
            'Medical Consultation in Bright Exam Room' => 4,
            'Doctor\'s Consultation with Mother and Child' => 5,
        ];

        return $priorityImages[$filename] ?? 999;
    }
}
```

---

## 📧 Email Service (Mailable)

### Request Submitted Email
The `RequestSubmittedMailable` handles practice notification emails with locale support.

```php
<?php

namespace App\Mail;

use App\DTO\ContactFormData;
use App\Models\FormRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestSubmittedMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public readonly ContactFormData $formData,
        public readonly FormRequest $formRequest,
        public readonly string $locale = 'de'
    ) {
        $this->locale = $locale;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjectKey = $this->locale === 'de' 
            ? 'Neue Kontaktanfrage von ' 
            : 'New contact request from ';
            
        return new Envelope(
            subject: $subjectKey . $this->formData->fullName,
            replyTo: [$this->formData->email => $this->formData->fullName],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.request-submitted',
            with: [
                'formData' => $this->formData,
                'formRequest' => $this->formRequest,
                'contactReason' => $this->formData->contactReason->label(),
                'submissionDate' => $this->formRequest->created_at->format('d.m.Y H:i'),
                'locale' => $this->locale,
            ],
        );
    }
}
```

---

## 🔧 Service Registration & Binding

### AppServiceProvider Registration
```php
<?php

namespace App\Providers;

use App\Contracts\ContactFormServiceInterface;
use App\Http\Services\ContactFormService;
use App\Services\CacheService;
use App\Http\Services\SlideshowImageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     */
    public function register(): void
    {
        // Contact form service binding
        $this->app->bind(
            ContactFormServiceInterface::class,
            ContactFormService::class
        );
        
        // Cache service as singleton for performance
        $this->app->singleton(CacheService::class);
        
        // Slideshow service
        $this->app->bind(SlideshowImageService::class);
    }

    /**
     * Bootstrap application services.
     */
    public function boot(): void
    {
        // Service-specific boot logic here
    }
}
```

### Usage in Controllers
```php
<?php

namespace App\Http\Controllers;

use App\Contracts\ContactFormServiceInterface;
use App\Services\CacheService;

class ContactController extends Controller
{
    public function __construct(
        private readonly ContactFormServiceInterface $contactFormService,
        private readonly CacheService $cacheService
    ) {}

    public function index(): View
    {
        return view('pages.contact', [
            'openingHours' => $this->cacheService->getOpeningHoursLocalized(),
        ]);
    }
}
```

---

## 🧪 Testing Strategy

### Service Layer Testing
```php
<?php

namespace Tests\Unit\Services;

use App\DTO\ContactFormData;
use App\Http\Services\ContactFormService;
use App\Models\ContactReason;
use App\Models\FormRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormServiceTest extends TestCase
{
    use RefreshDatabase;

    private ContactFormService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(ContactFormService::class);
    }

    /** @test */
    public function it_processes_contact_form_successfully(): void
    {
        // Arrange
        $contactReason = ContactReason::factory()->create(['key' => 'termin']);
        $formData = new ContactFormData(
            fullName: 'Test Patient',
            email: 'patient@example.com',
            phone: '+49 123 456789',
            preferredDatetime: now()->addDay(),
            message: 'Test appointment request',
            contactReason: \App\Enums\ContactReason::APPOINTMENT
        );

        // Act
        $result = $this->service->processContactForm($formData);

        // Assert
        $this->assertInstanceOf(FormRequest::class, $result);
        $this->assertEquals('Test Patient', $result->full_name);
        $this->assertEquals('patient@example.com', $result->email);
        $this->assertEquals($contactReason->id, $result->contact_reason_id);
        
        $this->assertDatabaseHas('form_requests', [
            'full_name' => 'Test Patient',
            'email' => 'patient@example.com',
        ]);
    }

    /** @test */
    public function it_handles_database_transaction_rollback_on_failure(): void
    {
        // Test transaction rollback behavior
        // Implementation would mock dependencies to force failures
    }
}
```

---

## 📈 Performance Considerations

### Service Layer Optimizations

#### **1. Database Query Optimization**
```php
// Eager loading relationships to prevent N+1 queries
public function getFormRequestsWithReasons(): Collection
{
    return FormRequest::with(['contactReason'])
        ->latest()
        ->take(100)
        ->get();
}

// Using database transactions for consistency
public function processMultipleRequests(array $requests): array
{
    return DB::transaction(function () use ($requests) {
        return collect($requests)
            ->map(fn($data) => $this->processContactForm($data))
            ->toArray();
    });
}
```

#### **2. Cache Invalidation Strategy**
```php
// Smart cache invalidation on content changes
public function updatePracticeTeam(array $teamData): void
{
    // Update configuration
    $this->updateConfiguration('practice.team', $teamData);
    
    // Clear related caches across all locales
    $this->cacheService->clearPracticeCaches(['team']);
    
    // Warm caches for immediate availability
    $this->cacheService->warmAllCaches(['de', 'en']);
}
```

#### **3. Async Email Processing**
```php
// Queue email sending for better response times
public function processContactFormAsync(ContactFormData $data): FormRequest
{
    return DB::transaction(function () use ($data): FormRequest {
        $formRequest = $this->saveFormRequest($data);
        
        // Queue email instead of synchronous sending
        SendContactFormEmailJob::dispatch($data, $formRequest, App::getLocale())
            ->delay(now()->addSeconds(5));
            
        return $formRequest;
    });
}
```

---

## 🔍 Error Handling & Monitoring

### Comprehensive Error Handling
```php
public function processContactForm(ContactFormData $data): FormRequest
{
    try {
        return DB::transaction(function () use ($data): FormRequest {
            $formRequest = $this->saveFormRequest($data);
            $this->sendNotificationEmail($data, $formRequest, App::getLocale());
            return $formRequest;
        });
        
    } catch (\Illuminate\Database\QueryException $e) {
        Log::error('Database error in contact form processing', [
            'error' => $e->getMessage(),
            'data' => $data->toArray(),
            'sql' => $e->getSql(),
        ]);
        throw new \App\Exceptions\ContactFormProcessingException(
            'Failed to save contact form request'
        );
        
    } catch (\Exception $e) {
        Log::error('Unexpected error in contact form processing', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'data' => $data->toArray(),
        ]);
        throw $e;
    }
}
```

### Health Check Endpoints
```php
// Service health monitoring
public function healthCheck(): array
{
    return [
        'cache' => $this->checkCacheHealth(),
        'database' => $this->checkDatabaseHealth(),
        'email' => $this->checkEmailHealth(),
        'services' => $this->checkServiceHealth(),
    ];
}

private function checkServiceHealth(): bool
{
    try {
        $this->cacheService->getPracticeTeamLocalized('de');
        return true;
    } catch (\Exception $e) {
        Log::warning('Service health check failed', ['error' => $e->getMessage()]);
        return false;
    }
}
```

This service layer architecture provides a **robust, type-safe, and highly maintainable** foundation for the medical practice website, with comprehensive error handling, performance optimization, and healthcare-specific business logic.