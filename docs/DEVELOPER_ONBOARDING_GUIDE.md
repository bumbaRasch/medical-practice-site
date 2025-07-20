# Developer Onboarding Guide - Modern Hausarzt Website

## Welcome to the Team! 👋

This guide will get you up and running with the Modern Hausarzt Website codebase. This is a professional medical practice website built with Laravel and enterprise-grade development practices.

---

## Table of Contents

1. [Project Overview](#project-overview)
2. [Quick Start Setup](#quick-start-setup)
3. [Understanding the Codebase](#understanding-the-codebase)
4. [Development Workflow](#development-workflow)
5. [Code Quality Standards](#code-quality-standards)
6. [Testing Guidelines](#testing-guidelines)
7. [Common Tasks](#common-tasks)
8. [Troubleshooting](#troubleshooting)
9. [Resources & References](#resources--references)

---

## Project Overview

### What You're Working On

You're joining the development team for a **modern German medical practice website** that demonstrates enterprise-grade Laravel development. This isn't just another website - it's a showcase of:

- 🏥 **Healthcare-focused UX** - Designed specifically for German "Hausarzt" practices
- 🌍 **Multilingual architecture** - German/English with automatic detection
- ⚡ **Performance optimization** - Multi-layer caching and response optimization
- 🛡️ **Enterprise security** - Healthcare-appropriate security measures
- 🧪 **Clean architecture** - SOLID principles with PHPStan Level 9 compliance

### Tech Stack at a Glance

```
🔧 Backend:    Laravel 12+ with PHP 8.3+
🎨 Frontend:   Blade templates + TailwindCSS v4
🗄️ Database:   SQLite with proper relationships and constraints
📧 Email:      Laravel Mailable with locale awareness
🚀 Caching:    Redis with multi-layer response caching
🔒 Security:   Security headers, structured logging, GDPR compliance
📊 Quality:    PHPStan Level 9, comprehensive testing
```

### Key Features You'll Be Working With

- **Contact Form System** - Patient appointment booking with email notifications
- **FAQ System** - Comprehensive patient information with category grouping
- **Team Management** - Localized staff profiles with performance caching
- **Dynamic Slideshow** - Automatic medical service photo display
- **Localization Engine** - Complete German/English translation system

---

## Quick Start Setup

### Prerequisites

Before you begin, ensure you have:

```bash
# Required software
- PHP 8.3+ with extensions (mbstring, xml, ctype, json, bcmath, pdo_sqlite)
- Composer 2.0+
- Node.js 18+ with npm
- SQLite 3.8+ (included with PHP)
- Redis 6.0+ (for caching)
- Git

# Recommended tools
- PHPStorm or VS Code with PHP extensions
- TablePlus or Sequel Pro for database management
- Redis Desktop Manager
- Postman for API testing
```

### Installation Steps

**1. Clone and Setup**
```bash
# Clone the repository
git clone <repository-url>
cd arzt-landing-page

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate
```

**2. Configure Environment**

Edit `.env` file with your local settings:
```ini
# Database (SQLite - automatically created)
DB_CONNECTION=sqlite
# DB_DATABASE=hausarzt_db_bumbara
# DB_USERNAME=your_mysql_username
# DB_PASSWORD=your_mysql_password

# Mail (use Mailpit for local development)
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_PRACTICE_EMAIL="test@example.com"

# Cache (ensure Redis is running)
CACHE_DRIVER=redis
SESSION_DRIVER=redis
```

**3. Database Setup**
```bash
# SQLite database is automatically created during migrations
# No database server setup required

# Run migrations and seed test data
php artisan migrate:fresh --seed
```

**4. Start Development Servers**
```bash
# Terminal 1: Laravel development server
php artisan serve

# Terminal 2: Asset compilation with hot reload
npm run dev

# Access application at http://localhost:8000
```

### Verify Your Setup

✅ **Application loads:** Visit http://localhost:8000  
✅ **Database works:** Check that team members and FAQ appear  
✅ **Localization works:** Try switching language with `?lang=en`  
✅ **Contact form works:** Submit a test form at `/kontakt`  
✅ **Code quality passes:** Run `./vendor/bin/phpstan analyse --level=9`

---

## Understanding the Codebase

### Architecture Overview

This project follows **Clean Architecture** principles with clear separation of concerns:

```
┌─────────────────────────────────────────┐
│  Controllers (HTTP Layer)              │ ← Handle HTTP requests/responses
├─────────────────────────────────────────┤
│  Services (Business Logic)             │ ← Core business operations
├─────────────────────────────────────────┤
│  DTOs (Data Transfer)                   │ ← Type-safe data transfer
├─────────────────────────────────────────┤
│  Models & Enums (Domain Layer)         │ ← Domain logic and data
├─────────────────────────────────────────┤
│  Database & External Services          │ ← Infrastructure layer
└─────────────────────────────────────────┘
```

### Key Directories

```
app/
├── Contracts/              # Interfaces for dependency injection
├── DTO/                   # Data Transfer Objects (type-safe data)
├── Enums/                 # PHP 8+ enums for type safety
├── Http/
│   ├── Controllers/       # HTTP request handlers
│   ├── Middleware/        # Request/response processing
│   ├── Requests/          # Form validation classes
│   └── Services/          # Business logic services
├── Mail/                  # Email templates and classes
├── Models/                # Eloquent models
└── Services/              # Application services (cache, theme)

resources/
├── lang/                  # Translations (de/en)
├── views/                 # Blade templates
└── css/js/               # Frontend assets

config/
└── practice.php          # Practice-specific configuration

docs/                     # Documentation you're reading now!
```

### Request Flow Example

Let's trace a contact form submission:

```
1. POST /form/request (web.php route)
2. LocaleMiddleware (sets language)
3. FormRequestController@submit
4. ContactFormRequest (validates input)
5. ContactFormData::fromArray (DTO creation)
6. ContactFormService->processContactForm (business logic)
7. Database transaction + email sending
8. Redirect with success message
```

### Code Patterns You'll See

**1. DTO Pattern (Data Transfer Objects)**
```php
// Type-safe, immutable data transfer
readonly class ContactFormData {
    public function __construct(
        public string $fullName,
        public string $email,
        public ?string $phone,
        // ...
    ) {}
}
```

**2. Service Layer Pattern**
```php
// Business logic separated from controllers
class ContactFormService implements ContactFormServiceInterface {
    public function processContactForm(ContactFormData $data): FormRequest {
        return DB::transaction(function () use ($data) {
            // Business logic here
        });
    }
}
```

**3. Enum-Driven Configuration**
```php
// Type-safe options
enum ContactReason: string {
    case APPOINTMENT = 'appointment';
    case URGENT_CARE = 'urgent_care';
    // ...
}
```

**4. Locale-Aware Caching**
```php
// Performance with localization
public function getPracticeTeamLocalized(string $locale): array {
    return Cache::remember("practice.team.{$locale}", now()->addDay(), function () {
        // Expensive operation with translations
    });
}
```

---

## Development Workflow

### Daily Development Process

**1. Start Your Day**
```bash
# Pull latest changes
git pull origin main

# Update dependencies if needed
composer install
npm install

# Start servers
php artisan serve &
npm run dev &
```

**2. Making Changes**
```bash
# Create feature branch
git checkout -b feature/your-feature-name

# Make your changes...

# Run quality checks before committing
./vendor/bin/phpstan analyse --level=9
php artisan test
npm run build  # Ensure assets compile
```

**3. Testing Your Changes**
```bash
# Test in both languages
http://localhost:8000/?lang=de
http://localhost:8000/?lang=en

# Test contact form
# Test FAQ functionality
# Test team page loading
```

**4. Commit and Push**
```bash
git add .
git commit -m "feat: add new feature description"
git push origin feature/your-feature-name

# Create pull request
```

### Branch Strategy

- `main` - Production-ready code
- `develop` - Integration branch (if used)
- `feature/description` - New features
- `fix/description` - Bug fixes
- `docs/description` - Documentation updates

### Code Review Checklist

Before submitting a PR, ensure:

✅ **PHPStan Level 9 passes** - `./vendor/bin/phpstan analyse --level=9`  
✅ **Tests pass** - `php artisan test`  
✅ **Both languages work** - Test German and English  
✅ **Code follows patterns** - Use existing DTOs, services, etc.  
✅ **No hardcoded strings** - Use translation keys  
✅ **Security headers work** - Check middleware applies  

---

## Code Quality Standards

### PHPStan Level 9 Compliance

This project maintains **PHPStan Level 9** - the strictest static analysis level. This means:

**✅ What This Gives Us:**
- **Type Safety** - All variables have known types
- **No Dynamic Properties** - No magic properties
- **Null Safety** - Explicit handling of nullable values
- **Array Safety** - Proper array type definitions

**❌ What You Can't Do:**
```php
// ❌ Dynamic properties
$user->some_property = 'value';  // Forbidden

// ❌ Untyped arrays
function process($data) {  // Must specify types
    return $data['key'];   // Array shape unknown
}

// ❌ Mixed types without union
function handle($input) {  // Must specify string|int|etc
}
```

**✅ What You Should Do:**
```php
// ✅ Properly typed properties
readonly class ContactFormData {
    public function __construct(public string $fullName) {}
}

// ✅ Typed method parameters
public function processForm(ContactFormData $data): FormRequest {
    // ...
}

// ✅ Explicit nullable handling
if ($data->phone !== null) {
    $cleanPhone = trim($data->phone);
}
```

### SOLID Principles in Practice

**Single Responsibility**
```php
// ✅ One concern per class
class ContactFormService {
    // Only handles contact form business logic
}

class EmailNotificationService {
    // Only handles email sending
}
```

**Dependency Injection**
```php
// ✅ Depend on interfaces, not concrete classes
class ContactFormService implements ContactFormServiceInterface {
    // Can be swapped for testing or different implementations
}
```

### Translation Requirements

**❌ Never hardcode strings:**
```php
// ❌ Don't do this
echo "Welcome to our practice";
$message = "Please fill out the form";
```

**✅ Always use translation keys:**
```php
// ✅ Do this
echo __('messages.welcome');
$message = __('messages.form.instruction');

// In Blade templates
{{ __('messages.nav.home') }}
```

---

## Testing Guidelines

### Test Structure

```
tests/
├── Feature/              # Integration tests
│   ├── ContactFormTest.php
│   └── SitemapTest.php
└── Unit/                 # Unit tests
    ├── ContactFormDataTest.php
    └── ExampleTest.php
```

### Writing Feature Tests

```php
class ContactFormTest extends TestCase
{
    public function test_contact_form_submission_with_valid_data(): void
    {
        $contactReason = ContactReason::factory()->create();
        
        $response = $this->post('/form/request', [
            'full_name' => 'Max Mustermann',
            'email' => 'max@example.com',
            'contact_reason_id' => $contactReason->id,
        ]);
        
        $response->assertRedirect('/kontakt');
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('form_requests', [
            'full_name' => 'Max Mustermann',
            'email' => 'max@example.com',
        ]);
    }
}
```

### Writing Unit Tests

```php
class ContactFormDataTest extends TestCase
{
    public function test_creates_contact_form_data_from_valid_array(): void
    {
        $contactReason = ContactReason::factory()->create();
        
        $data = ContactFormData::fromArray([
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'contact_reason_id' => $contactReason->id,
        ]);
        
        $this->assertEquals('Test User', $data->fullName);
        $this->assertEquals('test@example.com', $data->email);
        $this->assertFalse($data->hasPhone());
    }
}
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ContactFormTest.php

# Run with coverage (if configured)
php artisan test --coverage

# Run specific test method
php artisan test --filter test_contact_form_submission_with_valid_data
```

---

## Common Tasks

### Adding a New FAQ Question

**1. Add to configuration (`config/practice.php`):**
```php
'faq' => [
    // ... existing questions
    [
        'category' => 'messages.faq.categories.practice_info',
        'question' => 'messages.faq.questions.new_question.question',
        'answer' => 'messages.faq.questions.new_question.answer',
        'sort_order' => 10,
    ],
],
```

**2. Add translations (`resources/lang/de/messages.php`):**
```php
'faq' => [
    'questions' => [
        'new_question' => [
            'question' => 'Wie kann ich einen Termin vereinbaren?',
            'answer' => 'Sie können einen Termin telefonisch oder über unser Kontaktformular vereinbaren.',
        ],
    ],
],
```

**3. Add English translation (`resources/lang/en/messages.php`):**
```php
'faq' => [
    'questions' => [
        'new_question' => [
            'question' => 'How can I schedule an appointment?',
            'answer' => 'You can schedule an appointment by phone or using our contact form.',
        ],
    ],
],
```

**4. Clear cache and test:**
```bash
php artisan cache:clear
# Visit /faq and check both languages
```

### Adding a New Team Member

**1. Add image to `public/images/team/new-member.webp`**

**2. Update configuration:**
```php
'team' => [
    // ... existing members
    [
        'name' => 'messages.team.members.new_member.name',
        'role' => 'messages.team.members.new_member.role',
        'bio' => 'messages.team.members.new_member.bio',
        'image' => '/images/team/new-member.webp',
        'specializations' => ['messages.team.specializations.general_medicine'],
    ],
],
```

**3. Add translations for both languages**

**4. Test and clear cache**

### Adding a New Contact Reason

**1. Add to enum (`app/Enums/ContactReason.php`):**
```php
enum ContactReason: string
{
    // ... existing cases
    case NEW_REASON = 'new_reason';
}
```

**2. Create database migration:**
```bash
php artisan make:migration add_new_contact_reason
```

**3. Update seeder (`database/seeders/ContactReasonSeeder.php`):**
```php
ContactReason::create([
    'key' => \App\Enums\ContactReason::NEW_REASON->value,
    'name' => [
        'de' => 'Neuer Grund',
        'en' => 'New Reason',
    ],
    'sort_order' => 9,
    'is_active' => true,
]);
```

**4. Run migration:**
```bash
php artisan migrate:fresh --seed
```

### Debugging Performance Issues

**1. Enable query logging:**
```php
// In routes/web.php or controller
DB::enableQueryLog();
// ... your operations
dd(DB::getQueryLog());
```

**2. Check cache performance:**
```bash
# Monitor Redis
redis-cli monitor

# Check cache keys
redis-cli keys "*"

# Clear specific cache
php artisan cache:forget "practice.team.de"
```

**3. Profile with Telescope (if enabled):**
```bash
php artisan telescope:install
php artisan migrate
# Visit /telescope
```

---

## Troubleshooting

### Common Issues and Solutions

#### PHPStan Errors

**Problem:** "Property does not exist" errors
```bash
Property App\Models\User::$some_property does not exist.
```

**Solution:** Use proper type declarations
```php
// ❌ Dynamic property
$user->some_property = 'value';

// ✅ Proper attribute
class User extends Model {
    protected $fillable = ['some_property'];
}
```

**Problem:** "Array access might not exist"
```bash
Offset 'key' might not exist on array.
```

**Solution:** Check array keys or use proper typing
```php
// ❌ Unsafe array access
$value = $data['key'];

// ✅ Safe array access
$value = $data['key'] ?? null;
// or
if (isset($data['key'])) {
    $value = $data['key'];
}
```

#### Localization Issues

**Problem:** Translations not showing
```bash
# Check if translation key exists
php artisan tinker
>>> __('messages.nav.home')
```

**Solution:** 
1. Verify key exists in `resources/lang/de/messages.php`
2. Clear cache: `php artisan cache:clear`
3. Check locale is set: `App::getLocale()`

#### Cache Issues

**Problem:** Changes not appearing
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

**Problem:** Redis connection errors
```bash
# Check Redis is running
redis-cli ping
# Should return "PONG"

# Check configuration
php artisan tinker
>>> Cache::store('redis')->put('test', 'value')
>>> Cache::store('redis')->get('test')
```

#### Database Issues

**Problem:** Migration errors
```bash
# Check current migration status
php artisan migrate:status

# Rollback and retry
php artisan migrate:rollback
php artisan migrate

# Fresh start (loses data!)
php artisan migrate:fresh --seed
```

**Problem:** Foreign key constraint errors
```bash
# Check if referenced records exist
# Disable foreign key checks temporarily in migration:
Schema::disableForeignKeyConstraints();
// ... migration code
Schema::enableForeignKeyConstraints();
```

### Getting Help

**1. Check Documentation:**
- `docs/COMPREHENSIVE_DOCUMENTATION.md` - Complete system overview
- `docs/API_REFERENCE.md` - Service and DTO documentation
- `CLAUDE.md` - Project-specific guidance

**2. Use Development Tools:**
```bash
# Static analysis
./vendor/bin/phpstan analyse --level=9

# Debug with Tinker
php artisan tinker
>>> App\Models\FormRequest::count()
>>> Cache::get('practice.team.de')

# Check routes
php artisan route:list

# Check configuration
php artisan config:show practice
```

**3. Common Debug Commands:**
```bash
# View logs
tail -f storage/logs/laravel.log

# Check queue status (if using)
php artisan queue:work --verbose

# Check application status
php artisan about
```

---

## Resources & References

### Essential Documentation

📚 **Project Documentation:**
- [Comprehensive Documentation](docs/COMPREHENSIVE_DOCUMENTATION.md) - Complete system overview
- [API Reference](docs/API_REFERENCE.md) - Service layer documentation
- [Deployment Guide](docs/DEPLOYMENT_CONFIGURATION_GUIDE.md) - Production setup
- [CLAUDE.md](CLAUDE.md) - AI assistant guidance

📖 **External Resources:**
- [Laravel 11 Documentation](https://laravel.com/docs/11.x)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [TailwindCSS v4 Documentation](https://tailwindcss.com/docs)
- [PHP 8.3 Documentation](https://www.php.net/manual/en/)

### Code Quality Tools

🔧 **Static Analysis:**
```bash
# PHPStan (Level 9)
./vendor/bin/phpstan analyse --level=9

# PHP CS Fixer (if installed)
./vendor/bin/pint
```

🧪 **Testing:**
```bash
# PHPUnit tests
php artisan test
php artisan test --coverage
```

### Development Environment

🐳 **Docker (Alternative Setup):**
```bash
# If you prefer Docker
docker-compose up -d
docker-compose exec app php artisan migrate:fresh --seed
```

🛠️ **IDE Configuration:**

**PHPStorm:**
- Install Laravel Plugin
- Configure PHPStan integration
- Set up Blade syntax highlighting

**VS Code:**
- Laravel Extension Pack
- PHP Intelephense
- Tailwind CSS IntelliSense

### Performance Monitoring

📊 **Tools:**
```bash
# Laravel Telescope (installed)
php artisan telescope:install

# Debug bar (for development)
composer require barryvdh/laravel-debugbar --dev
```

### Community & Support

🤝 **Getting Connected:**
- Review existing code patterns before implementing new features
- Ask questions about architecture decisions
- Suggest improvements to development workflow
- Share knowledge about Laravel best practices

---

## Final Notes

Welcome to a codebase that demonstrates **enterprise-grade Laravel development**! This project showcases:

✨ **What Makes This Special:**
- **Clean Architecture** with SOLID principles
- **Type Safety** with PHPStan Level 9
- **Performance** with multi-layer caching
- **Internationalization** with professional German/English support
- **Security** with healthcare-appropriate measures
- **Maintainability** with comprehensive testing and documentation

🎯 **Your Mission:**
- Maintain the high code quality standards
- Follow established patterns and conventions
- Write tests for new functionality
- Keep documentation updated
- Think like a senior developer with focus on maintainability

🚀 **Ready to Contribute:**
You now have everything you need to be productive in this codebase. Remember:
- Code quality is non-negotiable (PHPStan Level 9)
- User experience matters (test in both languages)
- Performance is a feature (use caching appropriately)
- Security is paramount (especially for healthcare)

**Happy coding, and welcome to the team!** 🎉

---

*For questions about this guide or the codebase, check the documentation links above or create an issue for clarification.*