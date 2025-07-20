# API Reference - Modern Hausarzt Website

## Overview

This document provides detailed API reference for all services, DTOs, and interfaces in the Modern Hausarzt Website Laravel application.

---

## Table of Contents

1. [Service Layer APIs](#service-layer-apis)
2. [Data Transfer Objects (DTOs)](#data-transfer-objects-dtos)
3. [Enums & Constants](#enums--constants)
4. [Cache Service APIs](#cache-service-apis)
5. [Email Service APIs](#email-service-apis)
6. [Middleware APIs](#middleware-apis)
7. [Model APIs](#model-apis)

---

## Service Layer APIs

### ContactFormService

**Namespace:** `App\Http\Services\ContactFormService`  
**Interface:** `App\Contracts\ContactFormServiceInterface`  
**Purpose:** Handle contact form business logic with transaction safety and email notifications.

#### Methods

##### `processContactForm(ContactFormData $data): FormRequest`

**Description:** Process complete contact form submission with database persistence and email notification.

**Parameters:**
- `ContactFormData $data` - Validated form data transfer object

**Returns:** `FormRequest` - Persisted database model with ID

**Exceptions:**
- `Throwable` - Database transaction failure or email sending failure

**Process Flow:**
1. Begin database transaction
2. Persist form data to `form_requests` table
3. Log structured submission event
4. Send email notification to practice
5. Log email delivery status
6. Commit transaction or rollback on failure

**Example Usage:**
```php
$contactData = ContactFormData::fromArray($validatedData);
$formRequest = $contactFormService->processContactForm($contactData);
```

**Error Handling:**
- Database failures: Full transaction rollback
- Email failures: Data persisted, email failure logged
- Development environment: Exceptions re-thrown for debugging

---

##### `getRecentRequests(int $limit = 50): Collection<FormRequest>`

**Description:** Retrieve recent form submissions ordered by creation date.

**Parameters:**
- `int $limit` - Maximum number of requests to return (default: 50)

**Returns:** `Collection<FormRequest>` - Laravel collection of FormRequest models

**Example Usage:**
```php
$recentRequests = $contactFormService->getRecentRequests(25);
foreach ($recentRequests as $request) {
    echo $request->full_name . ' - ' . $request->created_at;
}
```

---

##### `getStatistics(): array<string, int>`

**Description:** Generate contact form statistics for administrative dashboard.

**Returns:**
```php
[
    'total_requests' => int,      // All-time total submissions
    'requests_today' => int,      // Today's submissions (24h)
    'requests_this_week' => int,  // Current week (Monday-Sunday)
    'requests_this_month' => int, // Current calendar month
]
```

**Example Usage:**
```php
$stats = $contactFormService->getStatistics();
echo "Total requests: " . $stats['total_requests'];
echo "Today's requests: " . $stats['requests_today'];
```

---

### CacheService

**Namespace:** `App\Services\CacheService`  
**Purpose:** Manage practice data caching with locale-aware performance optimization.

#### Methods

##### `getPracticeTeamLocalized(string $locale): array`

**Description:** Get localized team member data with 24-hour caching.

**Parameters:**
- `string $locale` - Language code (e.g., 'de', 'en')

**Returns:**
```php
[
    [
        'name' => string,           // Translated team member name
        'role' => string,           // Translated role/position
        'bio' => string,            // Translated biography
        'image' => string,          // Image path
        'specializations' => array, // Translated specializations
    ],
    // ... more team members
]
```

**Cache Key:** `practice.team.{locale}`  
**TTL:** 24 hours  

**Example Usage:**
```php
$team = $cacheService->getPracticeTeamLocalized(app()->getLocale());
```

---

##### `getFAQLocalized(string $locale): array`

**Description:** Get localized FAQ data grouped by category with caching.

**Parameters:**
- `string $locale` - Language code (e.g., 'de', 'en')

**Returns:**
```php
[
    'category_key' => [
        'name' => string,     // Translated category name
        'questions' => [
            [
                'question' => string, // Translated question
                'answer' => string,   // Translated answer
                'sort_order' => int,  // Display order
            ],
            // ... more questions
        ],
    ],
    // ... more categories
]
```

**Cache Key:** `practice.faq.{locale}`  
**TTL:** 24 hours  

---

##### `getServicesWithImages(string $locale): array`

**Description:** Get localized services with dynamic image detection.

**Parameters:**
- `string $locale` - Language code (e.g., 'de', 'en')

**Returns:**
```php
[
    [
        'title' => string,        // Translated service title
        'description' => string,  // Translated description
        'icon' => string,         // Icon identifier
        'images' => array,        // Array of image paths
    ],
    // ... more services
]
```

**Cache Key:** `practice.services.{locale}`  
**TTL:** 24 hours  

---

### SlideshowImageService

**Namespace:** `App\Http\Services\SlideshowImageService`  
**Purpose:** Dynamic image management for medical services slideshow.

#### Methods

##### `getImagesForService(string $serviceFolder): array`

**Description:** Get all images for a specific service from file system.

**Parameters:**
- `string $serviceFolder` - Service folder name (e.g., 'allgemeinmedizin')

**Returns:**
```php
[
    '/images/leistungen/folder/image1.webp',
    '/images/leistungen/folder/image2.webp',
    // ... more image paths
]
```

**Example Usage:**
```php
$images = $slideshowService->getImagesForService('allgemeinmedizin');
```

---

##### `getAllServiceImages(): array`

**Description:** Get all available service images organized by folder.

**Returns:**
```php
[
    'allgemeinmedizin' => [
        '/images/leistungen/allgemeinmedizin/image1.webp',
        // ... more images
    ],
    'vorsorge' => [
        '/images/leistungen/vorsorge/image1.webp',
        // ... more images
    ],
    // ... more service folders
]
```

---

## Data Transfer Objects (DTOs)

### ContactFormData

**Namespace:** `App\DTO\ContactFormData`  
**Type:** `readonly class` (immutable)  
**Purpose:** Type-safe transfer of validated contact form data.

#### Properties

```php
public string $fullName           // Required patient name
public string $email              // Required contact email
public ?string $phone             // Optional phone number
public ?Carbon $preferredDatetime // Optional appointment preference
public ?string $message           // Optional additional message
public ContactReason $contactReason // Required contact reason enum
```

#### Methods

##### `fromArray(array $data): ContactFormData`

**Description:** Factory method to create DTO from validated request data.

**Parameters:**
- `array $data` - Validated form data with keys matching property names

**Returns:** `ContactFormData` - Immutable DTO instance

**Validation Rules:**
- `full_name`: Required, non-empty string
- `email`: Required, non-empty string, valid email format
- `contact_reason_id`: Required, must exist in database
- `phone`: Optional, trimmed if provided
- `message`: Optional, trimmed if provided
- `preferred_datetime`: Optional, valid datetime string

**Exceptions:**
- `InvalidArgumentException` - Invalid or missing required data

**Example Usage:**
```php
$dto = ContactFormData::fromArray([
    'full_name' => 'Dr. Max Mustermann',
    'email' => 'max@example.com',
    'phone' => '+49 123 456789',
    'preferred_datetime' => '2024-12-25 10:00:00',
    'message' => 'Ich hätte gerne einen Termin.',
    'contact_reason_id' => 1,
]);
```

---

##### `toArray(): array<string, mixed>`

**Description:** Convert DTO to database-ready array format.

**Returns:**
```php
[
    'full_name' => string,
    'email' => string,
    'phone' => string|null,
    'preferred_datetime' => string|null,  // Y-m-d H:i:s format
    'message' => string|null,
    'contact_reason_id' => int,
]
```

**Example Usage:**
```php
$array = $dto->toArray();
FormRequest::create($array);
```

---

##### Utility Methods

**`hasPreferredDatetime(): bool`**
- Returns `true` if user specified a preferred appointment time

**`hasPhone(): bool`**
- Returns `true` if user provided a phone number

**`hasMessage(): bool`**
- Returns `true` if user included an additional message

**`getFormattedPreferredDatetime(): ?string`**
- Returns formatted datetime string (e.g., "25.12.2024 10:00") or null

---

## Enums & Constants

### ContactReason

**Namespace:** `App\Enums\ContactReason`  
**Type:** `string` enum  
**Purpose:** Type-safe contact reason options.

#### Cases

```php
case APPOINTMENT = 'appointment';           // General appointment request
case URGENT_CARE = 'urgent_care';           // Urgent medical care
case PRESCRIPTION = 'prescription';         // Prescription renewal
case MEDICAL_CERTIFICATE = 'medical_certificate'; // Medical certificate
case VACCINATION = 'vaccination';           // Vaccination appointment
case HEALTH_CHECKUP = 'health_checkup';     // Preventive checkup
case CONSULTATION = 'consultation';         // Medical consultation
case OTHER = 'other';                       // Other reasons
```

#### Database Integration

**Model:** `App\Models\ContactReason`  
**Table:** `contact_reasons`  
**Localization:** JSON column with translated names

```php
// Database seeder creates records like:
[
    'key' => ContactReason::APPOINTMENT->value,
    'name' => [
        'de' => 'Terminanfrage',
        'en' => 'Appointment Request',
    ],
    'sort_order' => 1,
    'is_active' => true,
]
```

---

### Locale

**Namespace:** `App\Enums\Locale`  
**Type:** `string` enum  
**Purpose:** Supported application locales.

#### Cases

```php
case GERMAN = 'de';     // German (primary)
case ENGLISH = 'en';    // English (secondary)
```

#### Methods

##### `getDisplayName(): string`

**Description:** Get human-readable locale name.

**Returns:**
- `'de'` → `'Deutsch'`
- `'en'` → `'English'`

---

### Theme

**Namespace:** `App\Enums\Theme`  
**Type:** `string` enum  
**Purpose:** Available website themes.

#### Cases

```php
case LIGHT = 'light';   // Light theme (default)
case DARK = 'dark';     // Dark theme
```

---

## Cache Service APIs

### Cache Keys & TTL

**Practice Data Caching:**
- `practice.team.{locale}` - Team members (24h TTL)
- `practice.faq.{locale}` - FAQ questions (24h TTL)
- `practice.services.{locale}` - Services list (24h TTL)
- `practice.navigation.{locale}` - Navigation menu (24h TTL)

**Response Caching:**
- Full page caching via `spatie/laravel-responsecache`
- 24-hour TTL for static pages
- Bypassed for admin routes and form submissions

### Cache Management Commands

```bash
# Warm all caches
php artisan cache:warm

# Clear response cache
php artisan responsecache:clear

# Clear application cache
php artisan cache:clear
```

---

## Email Service APIs

### RequestSubmittedMailable

**Namespace:** `App\Mail\RequestSubmittedMailable`  
**Purpose:** Email notification to practice when patient submits contact form.

#### Constructor

```php
public function __construct(
    ContactFormData $data,
    FormRequest $formRequest
)
```

#### Methods

##### `build(): Mailable`

**Description:** Build the email message with locale-aware content.

**Email Structure:**
- **To:** Practice email (from config)
- **Subject:** Localized subject line
- **Template:** `emails.request-submitted`
- **Locale:** Current application locale

**Template Variables:**
```php
[
    'data' => ContactFormData,     // Form submission data
    'formRequest' => FormRequest,  // Database model
    'practiceEmail' => string,     // Practice email address
]
```

---

## Middleware APIs

### LocaleMiddleware

**Namespace:** `App\Http\Middleware\LocaleMiddleware`  
**Purpose:** Automatic language detection and locale setting.

#### Methods

##### `handle(Request $request, Closure $next): Response`

**Description:** Process request to detect and set application locale.

**Detection Priority:**
1. URL parameter (`?lang=de`)
2. Session storage (`locale` key)
3. Browser `Accept-Language` header
4. Default locale (`de`)

**Side Effects:**
- Sets `App::setLocale()`
- Stores choice in session
- Updates locale for current request

---

### SecurityHeaders

**Namespace:** `App\Http\Middleware\SecurityHeaders`  
**Purpose:** Add security headers to all responses.

#### Headers Applied

```php
'X-Content-Type-Options' => 'nosniff',
'X-Frame-Options' => 'DENY',
'X-XSS-Protection' => '1; mode=block',
'Referrer-Policy' => 'strict-origin-when-cross-origin',
'Content-Security-Policy' => 'default-src \'self\'; ...',
```

---

## Model APIs

### FormRequest

**Namespace:** `App\Models\FormRequest`  
**Table:** `form_requests`  
**Features:** Soft deletes, timestamps, mass assignment protection

#### Fillable Attributes

```php
protected $fillable = [
    'full_name',
    'email', 
    'phone',
    'preferred_datetime',
    'message',
    'contact_reason_id',
];
```

#### Casts

```php
protected $casts = [
    'preferred_datetime' => 'datetime',
    'deleted_at' => 'datetime',
];
```

#### Relationships

##### `contactReason(): BelongsTo`

**Description:** Get the associated contact reason.

**Returns:** `ContactReason` model instance

```php
$formRequest = FormRequest::find(1);
$reason = $formRequest->contactReason;
echo $reason->name['de']; // Localized name
```

---

### ContactReason

**Namespace:** `App\Models\ContactReason`  
**Table:** `contact_reasons`  
**Purpose:** Store localized contact reason options.

#### Attributes

```php
protected $fillable = [
    'key',        // Enum value
    'name',       // JSON localized names
    'sort_order', // Display order
    'is_active',  // Enable/disable
];
```

#### Casts

```php
protected $casts = [
    'name' => 'array',      // JSON → PHP array
    'is_active' => 'boolean',
];
```

#### Relationships

##### `formRequests(): HasMany`

**Description:** Get all form requests using this reason.

**Returns:** Collection of `FormRequest` models

---

## Error Handling & Logging

### Structured Logging

**MedicalLogger Methods:**

##### `contactFormSubmitted(int $requestId, string $email, array $context): void`

**Purpose:** Log successful form submission with privacy-safe email hash.

##### `emailNotification(string $status, string $email, array $context): void`

**Purpose:** Log email sending status (success/failure).

##### `auditEvent(string $action, string $resource, array $context): void`

**Purpose:** Log administrative actions for compliance audit trail.

### Exception Handling

**Service Layer Exceptions:**
- Database failures: Wrapped in transactions, full rollback
- Email failures: Data preserved, failure logged, development re-throw
- Validation failures: `InvalidArgumentException` with descriptive messages

**Controller Exception Handling:**
- Form validation: Redirect with error messages
- Service failures: User-friendly error pages
- Development mode: Detailed error traces

---

This API reference provides comprehensive documentation for all public interfaces, methods, and data structures in the Modern Hausarzt Website application.