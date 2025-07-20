# Comprehensive Documentation - Modern Hausarzt Website

## Table of Contents
1. [Project Overview](#project-overview)
2. [Architecture & Design Patterns](#architecture--design-patterns)
3. [Core Components](#core-components)
4. [API Documentation](#api-documentation)
5. [Configuration Guide](#configuration-guide)
6. [Performance & Caching](#performance--caching)
7. [Localization System](#localization-system)
8. [Security Implementation](#security-implementation)
9. [Development Workflow](#development-workflow)
10. [Deployment Guide](#deployment-guide)

---

## Project Overview

**Project Name**: Modern Hausarzt Website  
**Framework**: Laravel 12+ with PHP 8.3+  
**Frontend**: Blade templates + TailwindCSS v4  
**Architecture**: Clean Architecture with SOLID principles  
**Quality Standard**: PHPStan Level 9 compliance  

### Key Features
- 🏥 **Medical Practice Website** - Professional German healthcare practice
- 🌍 **Multilingual Support** - German (primary) and English with automatic detection
- 📞 **Contact Form System** - Patient appointment booking with email notifications
- ❓ **FAQ System** - Comprehensive patient information with category grouping
- 👥 **Team Management** - Localized staff profiles with performance caching
- 📸 **Dynamic Slideshow** - Automatic medical service photo display
- ⚡ **Performance Optimization** - Multi-layer caching with response optimization
- 🛡️ **Enterprise Security** - Security headers, structured logging, audit trails

---

## Architecture & Design Patterns

### Clean Architecture Implementation

```
┌─────────────────┐
│   Presentation  │ ← Controllers, Views, Middleware
├─────────────────┤
│   Application   │ ← Services, DTOs, Contracts
├─────────────────┤
│    Domain       │ ← Models, Enums, Business Logic
├─────────────────┤
│ Infrastructure  │ ← Database, Mail, Cache, Logging
└─────────────────┘
```

### SOLID Principles Implementation

**Single Responsibility Principle (SRP)**
- Each controller handles one HTTP concern
- Services focus on specific business logic
- DTOs handle only data transfer

**Open/Closed Principle (OCP)**
- Interface-based services (`ContactFormServiceInterface`)
- Extensible enum systems (`ContactReason`, `Locale`)
- Configurable cache profiles

**Liskov Substitution Principle (LSP)**
- All service implementations follow strict contracts
- Middleware respects Laravel's middleware contract

**Interface Segregation Principle (ISP)**
- Focused service interfaces (contact form only)
- Specific cache service methods

**Dependency Inversion Principle (DIP)**
- Controllers depend on service interfaces
- Services use Laravel's facade abstractions

### Request Flow Architecture

```
Route → Middleware → FormRequest → Controller → DTO → Service → Model/Email → Response
  ↓         ↓            ↓           ↓        ↓        ↓          ↓            ↓
 web.php  Locale    Validation   HTTP     Type     Business   Data/Mail   Blade
          Security               Logic    Safety    Logic      Layer       View
```

---

## Core Components

### 1. Data Transfer Objects (DTOs)

**`ContactFormData` - Type-Safe Data Transfer**

```php
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
    
    // Factory methods, validation, conversion utilities
}
```

**Key Features:**
- ✅ **Immutable** - `readonly` class prevents data mutation
- ✅ **Type Safety** - PHPStan Level 9 compliant
- ✅ **Validation** - Built-in data validation in `fromArray()`
- ✅ **Conversion** - Database-ready `toArray()` method
- ✅ **Utility Methods** - `hasPhone()`, `hasMessage()`, etc.

### 2. Service Layer

**`ContactFormService` - Business Logic Separation**

```php
class ContactFormService implements ContactFormServiceInterface
{
    public function processContactForm(ContactFormData $data): FormRequest
    {
        return DB::transaction(function () use ($data): FormRequest {
            $formRequest = $this->saveFormRequest($data);
            $this->sendNotificationEmail($data, $formRequest, App::getLocale());
            return $formRequest;
        });
    }
}
```

**Architecture Benefits:**
- 🔒 **Database Transactions** - ACID compliance for data integrity
- 📧 **Email Integration** - Locale-aware notifications
- 📊 **Structured Logging** - Medical practice audit trails
- 🎯 **Single Responsibility** - Only contact form logic

### 3. Middleware System

**`LocaleMiddleware` - Language Detection**

```php
class LocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->detectLocale($request);
        App::setLocale($locale);
        session(['locale' => $locale]);
        return $next($request);
    }
}
```

**Detection Priority:**
1. URL parameter (`?lang=de`)
2. Session storage
3. Browser `Accept-Language` header
4. Default locale (`de`)

### 4. Enum-Driven Architecture

**`ContactReason` - Type-Safe Options**

```php
enum ContactReason: string
{
    case APPOINTMENT = 'appointment';
    case URGENT_CARE = 'urgent_care';
    case PRESCRIPTION = 'prescription';
    case MEDICAL_CERTIFICATE = 'medical_certificate';
    // ... more cases
}
```

**Database Integration:**
- ✅ **Type Safety** - Enum validation at PHP level
- ✅ **Database Constraints** - CHECK constraints ensure valid values
- ✅ **Localization** - JSON column with translated names

---

## API Documentation

### ContactFormService Interface

#### `processContactForm(ContactFormData $data): FormRequest`

**Purpose:** Process complete contact form submission with database persistence and email notification.

**Parameters:**
- `ContactFormData $data` - Validated form data from DTO

**Returns:** `FormRequest` - Persisted database model

**Exceptions:**
- `Throwable` - Database or email failures (wrapped in transaction)

**Process Flow:**
1. Begin database transaction
2. Save form request to database
3. Log submission with structured logging
4. Send email notification to practice
5. Log email status (success/failure)
6. Commit transaction or rollback on failure

#### `getRecentRequests(int $limit = 50): Collection<FormRequest>`

**Purpose:** Retrieve recent form submissions for administrative purposes.

**Parameters:**
- `int $limit` - Maximum number of requests (default: 50)

**Returns:** `Collection<FormRequest>` - Ordered by creation date (newest first)

#### `getStatistics(): array<string, int>`

**Purpose:** Generate contact form statistics for dashboard.

**Returns:**
```php
[
    'total_requests' => int,      // All-time total
    'requests_today' => int,      // Today's submissions
    'requests_this_week' => int,  // Current week
    'requests_this_month' => int, // Current month
]
```

### ContactFormData DTO

#### `fromArray(array $data): ContactFormData`

**Purpose:** Factory method to create DTO from validated request data.

**Parameters:**
- `array $data` - Validated form data

**Returns:** `ContactFormData` - Immutable DTO instance

**Validation:**
- Full name: Required, non-empty string
- Email: Required, non-empty string
- Contact reason ID: Required, must exist in database
- Phone: Optional, trimmed if provided
- Message: Optional, trimmed if provided
- Preferred datetime: Optional, valid Carbon date

**Exceptions:**
- `InvalidArgumentException` - Invalid or missing required data

#### `toArray(): array<string, mixed>`

**Purpose:** Convert DTO to database-ready array format.

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

---

## Configuration Guide

### Practice Configuration (`config/practice.php`)

**Services Configuration:**
```php
'services' => [
    [
        'title' => 'messages.services.general_medicine.title',
        'description' => 'messages.services.general_medicine.description',
        'icon' => 'stethoscope',
        'image_folder' => 'allgemeinmedizin',
    ],
    // ... more services
]
```

**Team Configuration:**
```php
'team' => [
    [
        'name' => 'messages.team.members.maria.name',
        'role' => 'messages.team.members.maria.role',
        'bio' => 'messages.team.members.maria.bio',
        'image' => '/images/team/maria-mustermann.webp',
        'specializations' => ['messages.team.specializations.family_medicine'],
    ],
    // ... more team members
]
```

**FAQ Configuration:**
```php
'faq' => [
    [
        'category' => 'messages.faq.categories.practice_info',
        'question' => 'messages.faq.questions.insurance_types.question',
        'answer' => 'messages.faq.questions.insurance_types.answer',
        'sort_order' => 1,
    ],
    // ... more questions
]
```

### Environment Configuration

**Database Settings:**
```ini
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

**Localization Settings:**
```ini
APP_LOCALE=de
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=de_DE
```

**Email Configuration:**
```ini
MAIL_PRACTICE_EMAIL=praxis@example.com
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
```

---

## Performance & Caching

### Multi-Layer Caching Architecture

```
┌─────────────────┐
│ Response Cache  │ ← Full page caching (24h TTL)
├─────────────────┤
│ Content Cache   │ ← Practice data, services, team (24h TTL)
├─────────────────┤
│ Locale Cache    │ ← Language-specific content (24h TTL)
├─────────────────┤
│ Fragment Cache  │ ← Blade @cache directives
└─────────────────┘
```

### CacheService Implementation

**Practice Data Caching:**
```php
public function getPracticeTeamLocalized(string $locale): array
{
    return Cache::remember("practice.team.{$locale}", now()->addDay(), function () use ($locale) {
        $team = config('practice.team', []);
        return collect($team)->map(function ($member) {
            return [
                'name' => __($member['name']),
                'role' => __($member['role']),
                'bio' => __($member['bio']),
                'image' => $member['image'],
            ];
        })->toArray();
    });
}
```

**Cache Benefits:**
- ⚡ **Performance** - Sub-100ms response times
- 🌍 **Locale-Specific** - Separate cache per language
- 🔄 **Auto-Invalidation** - 24-hour TTL with manual refresh
- 📊 **Monitoring** - Cache hit/miss tracking

### Response Caching

**Configuration (`config/responsecache.php`):**
```php
'enabled' => env('RESPONSE_CACHE_ENABLED', true),
'cache_time_in_minutes' => 60 * 24, // 24 hours
'cache_profile' => MedicalWebsiteCacheProfile::class,
```

**Custom Cache Profile:**
```php
class MedicalWebsiteCacheProfile extends CacheProfile
{
    public function shouldCacheRequest(Request $request): bool
    {
        return $request->isMethod('GET') && 
               !$request->is('admin/*') &&
               !str_contains($request->getUri(), 'nocache');
    }
}
```

---

## Localization System

### Language Support Architecture

**Supported Languages:**
- 🇩🇪 **German (`de`)** - Primary language
- 🇬🇧 **English (`en`)** - Secondary language

### Translation Structure

**File Organization:**
```
resources/lang/
├── de/messages.php  # German translations (primary)
└── en/messages.php  # English translations
```

**Translation Key Structure:**
```php
// Navigation
'nav.home' => 'Startseite',
'nav.services' => 'Leistungen',
'nav.team' => 'Team',

// Contact Form
'contact.form_title' => 'Kontakt aufnehmen',
'contact.form_success' => 'Vielen Dank für Ihre Nachricht!',

// Team Members
'team.members.maria.name' => 'Dr. Maria Mustermann',
'team.members.maria.role' => 'Hausärztin',
'team.members.maria.bio' => 'Erfahrene Allgemeinmedizinerin...',
```

### Locale Detection Flow

```
URL Parameter (?lang=de)
        ↓
Session Storage (locale)
        ↓
Browser Accept-Language
        ↓
Default Locale (de)
```

**Implementation:**
```php
private function detectLocale(Request $request): string
{
    // 1. Check URL parameter
    if ($request->has('lang')) {
        $lang = $request->get('lang');
        if (Locale::tryFrom($lang)) {
            return $lang;
        }
    }

    // 2. Check session
    if ($request->session()->has('locale')) {
        return $request->session()->get('locale');
    }

    // 3. Parse Accept-Language header
    $acceptLanguage = $request->header('Accept-Language', '');
    return $this->parseAcceptLanguageHeader($acceptLanguage);
}
```

---

## Security Implementation

### Security Headers Middleware

**`SecurityHeaders` Implementation:**
```php
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        return $response->withHeaders([
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'DENY',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Content-Security-Policy' => $this->getCSPHeader(),
        ]);
    }
}
```

### Structured Logging

**`MedicalLogger` - Healthcare-Specific Logging:**
```php
class MedicalLogger
{
    public static function contactFormSubmitted(int $requestId, string $email, array $context): void
    {
        Log::info('Contact form submitted', [
            'event' => 'contact_form_submitted',
            'request_id' => $requestId,
            'patient_email' => hash('sha256', $email), // Privacy-safe hash
            'context' => $context,
            'timestamp' => now()->toISOString(),
        ]);
    }

    public static function auditEvent(string $action, string $resource, array $context): void
    {
        Log::info('Audit event', [
            'event' => 'audit_event',
            'action' => $action,
            'resource' => $resource,
            'context' => $context,
            'timestamp' => now()->toISOString(),
        ]);
    }
}
```

### Data Privacy & GDPR Compliance

**Form Request Model - Soft Deletes:**
```php
class FormRequest extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'full_name', 'email', 'phone', 
        'preferred_datetime', 'message', 'contact_reason_id'
    ];
    
    protected $casts = [
        'preferred_datetime' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
```

**Privacy Features:**
- 🗑️ **Soft Deletes** - GDPR-compliant data removal
- 🔐 **Email Hashing** - Privacy-safe logging
- 📋 **Audit Trails** - Complete action logging
- 🛡️ **Input Validation** - XSS/injection prevention

---

## Development Workflow

### Code Quality Standards

**PHPStan Level 9 Configuration:**
```neon
parameters:
    level: 9
    paths:
        - app
    checkMissingIterableValueType: false
    treatPhpDocTypesAsCertain: false
```

**Quality Checks:**
```bash
# Static analysis
./vendor/bin/phpstan analyse --level=9

# Unit tests
php artisan test

# Code formatting
./vendor/bin/pint
```

### Adding New Features

**1. Model/Migration Creation:**
```bash
php artisan make:model ModelName -m
php artisan make:enum EnumName
```

**2. Form Handling:**
```bash
php artisan make:request FormNameRequest
php artisan make:mail MailableName
```

**3. Business Logic:**
```bash
php artisan make:interface ServiceInterface
# Implement service class with interface
```

**4. Controller Creation:**
```bash
php artisan make:controller ControllerName
```

### Testing Strategy

**Feature Tests:**
```php
class ContactFormTest extends TestCase
{
    public function test_contact_form_submission_success(): void
    {
        $response = $this->post('/form/request', [
            'full_name' => 'Max Mustermann',
            'email' => 'max@example.com',
            'contact_reason_id' => ContactReason::find(1)->id,
        ]);
        
        $response->assertRedirect('/kontakt')
                 ->assertSessionHas('success');
    }
}
```

**Unit Tests:**
```php
class ContactFormDataTest extends TestCase
{
    public function test_creates_from_valid_array(): void
    {
        $data = ContactFormData::fromArray([
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'contact_reason_id' => 1,
        ]);
        
        $this->assertEquals('Test User', $data->fullName);
        $this->assertEquals('test@example.com', $data->email);
    }
}
```

---

## Deployment Guide

### Production Optimization

**Optimization Script (`scripts/optimize-production.sh`):**
```bash
#!/bin/bash
set -e

echo "🚀 Optimizing Laravel application for production..."

# Install dependencies
composer install --optimize-autoloader --no-dev

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build optimized assets
npm run build

# Warm application caches
php artisan cache:warm --force

echo "✅ Production optimization complete!"
```

### Docker Configuration

**`docker-compose.yml`:**
```yaml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "8000:8000"
    environment:
      - APP_ENV=production
    volumes:
      - ./database/database.sqlite:/app/database/database.sqlite
```

### Performance Monitoring

**Cache Warming Commands:**
```bash
# Warm all caches
php artisan cache:warm

# Warm specific cache types
php artisan cache:warm --content
php artisan cache:warm --response

# Clear and refresh
php artisan responsecache:clear
php artisan cache:warm --force
```

### Database Management

**Migration Commands:**
```bash
# Run migrations
php artisan migrate

# Reset with fresh data
php artisan migrate:fresh --seed

# Rollback migrations
php artisan migrate:rollback
```

### Environment-Specific Configuration

**Production Environment:**
```ini
APP_ENV=production
APP_DEBUG=false
APP_URL=https://hausarzt-praxis.de

# Performance
RESPONSE_CACHE_ENABLED=true
CACHE_DRIVER=redis
SESSION_DRIVER=redis

# Security
SECURE_COOKIES=true
HTTPS_ONLY=true
```

**Development Environment:**
```ini
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Development tools
TELESCOPE_ENABLED=true
LOG_LEVEL=debug
```

---

## Conclusion

This documentation provides a comprehensive overview of the Modern Hausarzt Website, showcasing enterprise-grade Laravel development with:

- ✅ **Clean Architecture** - SOLID principles and separation of concerns
- ✅ **Type Safety** - PHPStan Level 9 compliance throughout
- ✅ **Performance** - Multi-layer caching and optimization
- ✅ **Internationalization** - Complete German/English localization
- ✅ **Security** - Healthcare-appropriate security measures
- ✅ **Maintainability** - Well-documented, testable code

The codebase serves as a reference implementation for modern medical practice websites with professional-grade architecture and comprehensive patient information systems.