# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

# Project: Modern Hausarzt Website (Laravel + Blade)

Create a modern, professional, and accessible website for a German general medical practice ("Hausarzt"), with a superior user experience and code quality compared to existing medical practice websites.

---

## 🚀 Development Commands

### Initial Setup (if project not initialized)
```bash
# Create new Laravel project
composer create-project laravel/laravel arzt-landing-page

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Set up database
php artisan migrate
php artisan db:seed
```

### Common Development Commands
```bash
# Start development server
php artisan serve

# Run database operations
php artisan migrate
php artisan migrate:fresh --seed  # Reset and re-run all migrations with seeds

# Build frontend assets
npm run dev     # Development build with hot reload
npm run build   # Production build

# Code quality checks
./vendor/bin/phpstan analyse --level=9  # PHPStan static analysis
php artisan test                        # Run PHPUnit tests

# Artisan commands
php artisan make:controller ControllerName
php artisan make:request RequestName
php artisan make:mail MailableName
php artisan make:migration create_table_name
php artisan make:middleware MiddlewareName
php artisan make:enum EnumName

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Docker Commands
```bash
# Start Docker containers
docker-compose up -d

# Stop containers
docker-compose down

# Access MySQL CLI
docker exec -it hausarzt-db mysql -u laravel_hausarzt_bumbara -p
```

### Performance & Caching Commands
```bash
# Install performance packages
composer require spatie/laravel-responsecache

# Cache management
php artisan cache:warm                    # Warm all caches
php artisan cache:warm --force           # Force refresh all caches
php artisan cache:warm --content         # Warm only content cache
php artisan cache:warm --response        # Warm only response cache

# Response cache management
php artisan responsecache:clear           # Clear response cache
php artisan responsecache:flush           # Flush all response cache

# Production optimization
./scripts/optimize-production.sh         # Full production optimization
npm run build                           # Build optimized assets
php artisan config:cache                # Cache configuration
php artisan route:cache                 # Cache routes
php artisan view:cache                  # Cache views
```

---

## 🏗️ Architecture Overview

### Request Flow
1. **Route** (`routes/web.php`) → Maps URL to controller action
2. **Middleware** (`app/Http/Middleware/`) → Locale detection, authentication, etc.
3. **FormRequest** (`app/Http/Requests/`) → Validates incoming data
4. **Controller** (`app/Http/Controllers/`) → Handles HTTP request/response
5. **DTO** (`app/DTO/`) → Type-safe data transfer object
6. **Service** (`app/Http/Services/`) → Business logic layer
7. **Model/Enum** (`app/Models/`, `app/Enums/`) → Data layer
8. **Mailable** (`app/Mail/`) → Email composition and sending
9. **View** (`resources/views/`) → Blade template rendering

### Key Architectural Decisions

- **No JavaScript frameworks**: Pure server-side rendering with Blade + TailwindCSS v4
- **Strict typing**: PHPStan Level 9 enforces type safety throughout
- **DTO pattern**: All validated data passes through DTOs for type safety
- **Service layer**: Business logic separated from controllers with interfaces
- **Enum-driven**: Contact reasons and other options use PHP 8+ enums
- **Middleware-based localization**: Single middleware handles all locale detection
- **German-first**: All user-facing content in German via Laravel localization
- **Performance-first**: Multi-layer caching with response caching, content caching, and asset optimization
- **Optimized CSS**: TailwindCSS v4 with JIT compilation and aggressive purging

### Middleware Stack
- **CacheResponse**: Response caching middleware (spatie/laravel-responsecache) for full-page caching
- **LocaleMiddleware**: Handles automatic language detection from URL params, session, or browser headers

### Performance Architecture
- **Response Caching**: Full-page caching with spatie/laravel-responsecache (24-hour TTL)
- **Content Caching**: CacheService for practice data, services, team, FAQ (24-hour TTL)
- **Locale-Specific Caching**: Team members, FAQ, navigation, opening hours cached per language
- **Fragment Caching**: Blade directives @cache/@endcache for reusable components
- **Asset Optimization**: Vite with CSS/JS minification, tree-shaking, and bundle splitting
- **CSS Purging**: TailwindCSS v4 with comprehensive content purging (70-90% size reduction)

### PHPStan Configuration
```neon
parameters:
    level: 9
    paths:
        - app
    checkMissingIterableValueType: false
    treatPhpDocTypesAsCertain: false
```

---

## 🔧 Tech Stack

- **Laravel 12+**, PHP 8.3+
- **Blade templates** (modular and extendable)
- **TailwindCSS v4** with @theme syntax (no traditional config file)
- **Vite** for asset bundling with TailwindCSS plugin
- Form handling via **Laravel controllers + FormRequest + DTO + Service**
- Email sending via Laravel `Mailable`
- Localization via `resources/lang/{locale}/messages.php`
- Strict static analysis with **PHPStan Level 9**
- **PHP Enums** for type-safe options

---

## 🌍 Localization System

### Language Support
- **Primary language**: German (`de`)
- **Secondary language**: English (`en`)
- All views use Laravel's localization system via `__('messages.key')`
- Automatic language detection via middleware
- **Locale-aware caching**: Team members, navigation, and opening hours cached per language

### LocaleMiddleware Features
- **Priority order**: URL parameter (`?lang=de`) → Session → Browser Accept-Language → Default
- **Browser parsing**: Handles complex Accept-Language headers with quality values
- **Session persistence**: Remembers user's language choice
- **Type safety**: PHPStan Level 9 compliant

### Translation Structure
```
resources/lang/
├── de/messages.php  # German translations (primary)
└── en/messages.php  # English translations
```

### Team Member Localization System
Team member data uses a two-tier approach for optimal performance:

**Configuration Layer** (`config/practice.php`):
```php
'team' => [
    [
        'name' => 'messages.team.members.maria.name',
        'role' => 'messages.team.members.maria.role', 
        'bio' => 'messages.team.members.maria.bio',
        'image' => '/images/team/maria-mustermann.webp',
    ],
    // ...
]
```

**Service Layer** (`CacheService::getPracticeTeamLocalized()`):
- Loads raw config with translation keys
- Applies `__()` translations based on current locale
- Caches translated data separately for each language
- Returns fully localized team member arrays

**Benefits**:
- ✅ **Performance**: Translated data cached per locale (24-hour TTL)
- ✅ **Type Safety**: PHPStan Level 9 compliant
- ✅ **Maintainability**: Translation keys in config, content in lang files
- ✅ **Scalability**: Easy to add new languages without config changes

### Usage Examples
```php
// In views
{{ __('messages.nav.home') }}
{{ __('messages.contact.form_title') }}

// In controllers  
return redirect()->with('success', __('messages.contact.form_success'));

// Team localization (handled by CacheService)
$team = $this->cacheService->getPracticeTeamLocalized($locale);

// Language switching
<a href="{{ url()->current() }}?lang=en">English</a>
```

### FAQ System Architecture
The FAQ system provides comprehensive patient information with full localization support:

**Configuration Layer** (`config/practice.php`):
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

**Service Layer** (`CacheService::getFAQLocalized()`):
- Loads raw config with translation keys
- Groups questions by category with automatic sorting
- Applies `__()` translations based on current locale
- Caches grouped FAQ data separately for each language
- Returns structured array with categories and questions

**Content Categories**:
- **🏥 Practice Information**: Insurance acceptance, new patients, practice policies
- **📅 Appointments & Hours**: Scheduling speed, same-day availability, online booking
- **🩺 Services**: Medical certificates, preventive care, house calls, procedures
- **📋 First Visit**: Required documents, insurance cards, preparation guidelines

**UI Features**:
- **Accordion Interface**: Smooth collapsible sections with JavaScript
- **Category Grouping**: Questions organized by logical categories
- **Accessibility**: ARIA attributes, keyboard navigation, screen reader support
- **Mobile Responsive**: Optimized for all device sizes
- **Performance**: Cached translations with 24-hour TTL

**Benefits**:
- ✅ **Reduces Admin Burden**: Answers common patient questions automatically
- ✅ **Improves Patient Experience**: 24/7 access to essential practice information
- ✅ **SEO Optimization**: Rich, relevant content for search engines
- ✅ **Multilingual Support**: Complete German/English localization
- ✅ **Easy Maintenance**: Add questions via config without code changes

---

## 🎨 Design System

### TailwindCSS v4 Configuration
Uses the new `@theme` syntax in `resources/css/app.css`:

```css
@import "tailwindcss";

@theme {
  --color-medical-blue: #4A90E2;
  --color-medical-light-blue: #E6F2FF;
  --color-medical-gray: #F5F5F5;
  --font-family-sans: Inter, Arial, sans-serif;
}
```

### Design Guidelines
- **Color palette**: Medical blue (#4A90E2), light blue (#E6F2FF), soft gray (#F5F5F5)
- **Typography**: Inter font family for clean, medical appearance
- **Layout**: Minimalist, calm, trustworthy design
- **Responsive**: Mobile-first approach
- **Accessibility**: WCAG compliant with semantic HTML5
- **SEO**: Optimized headings, meta tags, alt attributes

---

## 📄 Pages & Routing

### Route Structure
```
/                    → HomeController@index
/leistungen         → ServicesController@index  
/team               → TeamController@index
/faq                → FaqController@index
/kontakt            → ContactController@index
POST /form/request  → FormRequestController@submit
```

### Page Controllers
Each page has a dedicated controller following Single Responsibility Principle:

- `HomeController` - Homepage with hero, benefits, opening hours
- `ServicesController` - Medical services with dynamic slideshow from config
- `TeamController` - Staff information with full localization support
- `FaqController` - Frequently asked questions with category grouping
- `ContactController` - Contact information and appointment booking form
- `FormRequestController` - Contact form submission handling with email notifications

### View Structure
```
resources/views/
├── layouts/app.blade.php           # Base layout with performance optimizations
├── components/
│   ├── _header.blade.php           # Navigation with language switcher and mobile menu
│   ├── _footer.blade.php           # Footer with practice info and navigation
│   ├── _service-icon.blade.php     # Reusable service icon component
│   └── services-slideshow.blade.php # Dynamic photo slideshow component
├── pages/                          # Page templates
│   ├── home.blade.php              # Homepage with hero and benefits
│   ├── services/index.blade.php    # Services overview with slideshow
│   ├── team.blade.php              # Team members with localization
│   ├── faq.blade.php               # FAQ with accordion interface
│   ├── contact.blade.php           # Contact form and practice info
│   └── legal/                      # Legal pages (privacy, imprint, terms)
└── emails/                         # Email templates for notifications
```

---

## 📞 Contact Form System

### Architecture
```
ContactFormRequest → ContactFormData (DTO) → ContactFormService → RequestSubmittedMailable
```

### Components

**FormRequest Validation:**
```php
// app/Http/Requests/ContactFormRequest.php
- Form validation rules
- Custom error messages using translations
- Attribute name translations
```

**DTO (Data Transfer Object):**
```php
// app/DTO/ContactFormData.php
- Readonly class with strict typing
- Static factory method fromArray()
- Conversion methods (toArray(), etc.)
- Helper methods (hasPhone(), hasMessage(), etc.)
```

**Service Layer:**
```php
// app/Http/Services/ContactFormService.php
- Implements ContactFormServiceInterface
- Database transaction handling
- Email sending with locale support
- Error logging and recovery
```

**Contact Reason System:**
```php
// app/Enums/ContactReason.php - PHP enum with 8 predefined options
// app/Models/ContactReason.php - Database model with JSON localized names
```

### Database Tables

**form_requests:**
| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary key |
| full_name | STRING | Required patient name |
| email | STRING | Required contact email |
| phone | STRING? | Optional phone number |
| preferred_datetime | DATETIME? | Optional appointment preference |
| message | TEXT? | Optional additional message |
| contact_reason_id | BIGINT | Foreign key to contact_reasons |
| created_at | TIMESTAMP | Submission time |
| updated_at | TIMESTAMP | Last modified |
| deleted_at | TIMESTAMP? | Soft delete (GDPR) |

**contact_reasons:**
| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary key |
| key | STRING | Enum value (validates against ContactReason enum) |
| name | JSON | Localized names {"de": "...", "en": "..."} |
| sort_order | INTEGER | Display order |
| is_active | BOOLEAN | Enable/disable option |

### Features
- **Enum-driven options**: Contact reasons backed by PHP enum
- **Database validation**: CHECK constraint ensures only enum values
- **Localized options**: JSON column with translations
- **Email notifications**: Sent to practice with user's locale
- **GDPR compliance**: Soft deletes enabled
- **Error handling**: Graceful fallbacks, comprehensive logging

---

## 🧠 Code Quality Standards

### PHPStan Level 9 Compliance
- **Strict typing**: All properties and methods properly typed
- **No dynamic properties**: Readonly DTOs and typed models
- **Array shape validation**: Proper array type annotations
- **Null safety**: Explicit nullable types and null checks

### SOLID Principles Implementation
- **S**: Single Responsibility - Each class has one clear purpose
- **O**: Open/Closed - Interfaces allow extension without modification  
- **L**: Liskov Substitution - All implementations follow contracts
- **I**: Interface Segregation - Focused interfaces (ContactFormServiceInterface)
- **D**: Dependency Inversion - Services depend on abstractions

### Design Patterns
- **DTO Pattern**: Type-safe data transfer between layers
- **Service Layer**: Business logic separation from controllers
- **Factory Pattern**: Static factory methods in DTOs
- **Repository Pattern**: Models encapsulate data access
- **Strategy Pattern**: Configurable services via interfaces

### File Organization
```
app/
├── Contracts/                      # Interfaces
├── DTO/                           # Data transfer objects
├── Enums/                         # PHP 8+ enums
├── Http/
│   ├── Controllers/               # HTTP request handlers
│   ├── Middleware/                # Request/response middleware
│   ├── Requests/                  # Form validation
│   └── Services/                  # Business logic
├── Mail/                          # Email templates and logic
├── Models/                        # Database models
└── Providers/                     # Service bindings
```

---

## 🗃️ Configuration Management

### Practice Configuration
Static practice data stored in `config/practice.php`:
```php
return [
    'services' => [
        // Medical services with translation keys
        ['title' => 'messages.services.general_medicine.title', ...],
        // ... more services
    ],
    'team' => [
        // Team members with localized content
        ['name' => 'messages.team.members.maria.name', ...],
        // ... more team members  
    ],
    'faq' => [
        // FAQ questions grouped by category
        ['category' => 'messages.faq.categories.practice_info', ...],
        // ... more questions
    ],
];
```

**Key Configuration Sections**:
- **Services**: Medical services with icons and descriptions
- **Team**: Staff information with photos, roles, and bios
- **FAQ**: Frequently asked questions organized by category
- **All content**: Uses translation keys for full localization support

### Environment Variables
```ini
# Database
DB_CONNECTION=mysql
DB_HOST=db
DB_DATABASE=hausarzt_db_bumbara
DB_USERNAME=laravel_hausarzt_bumbara
DB_PASSWORD=secret_password_hausartz_bumba

# Localization
APP_LOCALE=de
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=de_DE

# Mail
MAIL_PRACTICE_EMAIL=praxis@example.com
```

---

## 🔄 Development Workflow

### Adding New Features
1. **Planning**: Define requirements and update todos
2. **Models**: Create/update models and enums if needed
3. **Migrations**: Database schema changes
4. **Validation**: FormRequest for input validation
5. **DTO**: Type-safe data transfer objects
6. **Service**: Business logic implementation
7. **Controller**: HTTP request handling
8. **Views**: Blade templates with translations
9. **Testing**: PHPStan Level 9 compliance
10. **Documentation**: Update CLAUDE.md if needed

### Adding Translations
1. Add keys to `resources/lang/de/messages.php` (primary)
2. Add corresponding keys to `resources/lang/en/messages.php`
3. Use in views: `{{ __('messages.section.key') }}`
4. Test with language switcher

### Database Changes
1. Create migration: `php artisan make:migration description`
2. Update models with proper relationships
3. Create/update factories for testing data
4. Run: `php artisan migrate:fresh --seed`

---

## 🚫 Important Constraints

### What NOT to Do
- **Never create JavaScript frameworks** - Keep it server-side only
- **Never bypass middleware** - All locale handling goes through LocaleMiddleware
- **Never hardcode strings** - Always use translation keys
- **Never skip PHPStan** - Maintain Level 9 compliance
- **Never create admin interfaces** - This is a simple contact form system
- **Never use dynamic properties** - Use readonly DTOs and proper typing

### File Creation Guidelines
- **NEVER create files** unless absolutely necessary for the goal
- **ALWAYS prefer editing** existing files over creating new ones
- **NEVER proactively create** documentation files unless explicitly requested
- **Follow existing patterns** when creating required files

---

## 🎯 Project Goals

### Primary Objectives
- **Professional medical website** with clean, trustworthy design optimized for German healthcare
- **Comprehensive patient information** through FAQ system addressing common medical practice concerns
- **Multilingual support** with automatic detection and full German/English localization
- **Contact form system** for appointment requests with email notifications
- **Accessibility compliance** for all users including screen readers and keyboard navigation
- **Enterprise-grade code quality** with strict typing and performance optimization

### Current Website Structure
- **🏠 Homepage** (`/`) - Practice overview, hero section, benefits, opening hours
- **⚕️ Services** (`/leistungen`) - Medical services with dynamic photo slideshow
- **👥 Team** (`/team`) - Team members with full localization and professional profiles
- **❓ FAQ** (`/faq`) - Comprehensive Q&A system with medical practice focus
- **📞 Contact** (`/kontakt`) - Contact form, practice information, and appointment booking

### Success Metrics
- ✅ **PHPStan Level 9 compliance** maintained across entire codebase
- ✅ **Complete localization** for all user-facing content (German/English)
- ✅ **Contact form system** processes submissions reliably with email notifications
- ✅ **FAQ system** provides comprehensive patient information in both languages
- ✅ **Team localization** supports multiple languages with performance caching
- ✅ **Dynamic slideshow** loads all practice photos automatically
- ✅ **Responsive design** works optimally on all devices and screen sizes
- ✅ **Performance optimization** with multi-layer caching (response, content, locale-specific)
- ✅ **Accessibility compliance** with ARIA attributes and semantic HTML
- ✅ **Clean architecture** following SOLID principles with proper separation of concerns

---

## AI Assistant Notes

This project demonstrates modern Laravel development with enterprise-grade medical practice features:

### **Core Features Implemented**
- **🎯 FAQ System**: Comprehensive patient Q&A with category grouping and full localization
- **👥 Team Localization**: Complete multilingual team member profiles with performance caching
- **📸 Dynamic Slideshow**: Automatic photo loading from directory with localized descriptions
- **📞 Contact System**: Professional appointment booking with email notifications
- **🔄 Performance Caching**: Multi-layer caching (response, content, locale-specific)

### **Technical Excellence**
- **Type Safety**: PHPStan Level 9 ensures enterprise-grade code quality throughout
- **Clean Architecture**: SOLID principles with proper separation of concerns via DTOs and Services
- **Internationalization**: Professional German/English localization via middleware and caching
- **Modern Frontend**: TailwindCSS v4 with semantic HTML5 and accessibility compliance
- **Email Integration**: Locale-aware notifications with proper GDPR compliance

### **Medical Practice Optimization**
- **German Healthcare Focus**: Content specifically designed for "Hausarzt" practices
- **Patient Information Architecture**: FAQ addresses insurance, appointments, services, first visits
- **Professional Design**: Clean, trustworthy medical aesthetic with calm color palette
- **Accessibility**: WCAG compliant with screen reader support and keyboard navigation
- **SEO Optimized**: Rich content with proper meta tags and semantic structure

### **Development Principles**
When working on this codebase:
1. **Always maintain PHPStan Level 9 compliance** - no exceptions
2. **Use translation keys for all content** - never hardcode strings
3. **Follow established localization patterns** - config → service → cache → view
4. **Preserve performance optimizations** - maintain caching layers
5. **Test in both languages** - ensure German/English parity
6. **Follow medical practice context** - content should be appropriate for healthcare

This codebase serves as a reference implementation for modern medical practice websites with enterprise-grade Laravel architecture, full internationalization, and comprehensive patient information systems.