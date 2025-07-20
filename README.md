# Modern Hausarzt Website (Laravel + SQLite)

A professional, accessible website for a German general medical practice ("Hausarzt"), built with Laravel and SQLite for simplicity and performance.

## 🏥 Project Overview

This project creates a modern, professional website for a German general medical practice with superior user experience and code quality compared to existing medical practice websites.

### Key Features

- **Modern Design**: Clean, trustworthy medical aesthetic with calm color palette
- **Multilingual Support**: Complete German/English localization with automatic detection
- **Contact System**: Professional appointment booking with email notifications
- **FAQ System**: Comprehensive patient Q&A addressing common medical practice concerns
- **Team Profiles**: Complete multilingual team member profiles with performance caching
- **Accessibility**: WCAG compliant with screen reader support and keyboard navigation
- **Performance**: Multi-layer caching (response, content, locale-specific)

## 🚀 Quick Start

### Prerequisites

- PHP 8.3+ with SQLite extension
- Composer
- Node.js & npm

### Installation

```bash
# Clone the repository
git clone <repository-url>
cd arzt-landing-page

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup (SQLite)
php artisan migrate:fresh --seed

# Build frontend assets
npm run build

# Start development server
php artisan serve
```

The application will be available at `http://localhost:8000`

## 🗃️ Database Configuration

This project uses **SQLite** for simplicity and ease of deployment:

- **Database file**: `database/database.sqlite`
- **Connection**: Configured automatically via Laravel's SQLite driver
- **No external database server required**

### Database Commands

```bash
# Run migrations
php artisan migrate

# Fresh migrations with sample data
php artisan migrate:fresh --seed

# Seed database with sample data
php artisan db:seed

# Direct SQLite CLI access
sqlite3 database/database.sqlite
```

## 🏗️ Tech Stack

- **Backend**: Laravel 12+ with PHP 8.3+
- **Database**: SQLite (no external server required)
- **Frontend**: Blade templates + TailwindCSS v4
- **Assets**: Vite for bundling and optimization
- **Localization**: Laravel's built-in localization system
- **Email**: Laravel Mailable with configurable SMTP
- **Caching**: Multi-layer caching with spatie/laravel-responsecache
- **Code Quality**: PHPStan Level 9 for strict type safety

## 🌍 Localization

- **Primary**: German (`de`)
- **Secondary**: English (`en`)
- **Automatic detection**: URL parameter → Session → Browser Accept-Language
- **Performance**: Locale-aware caching for optimal performance

## 📄 Project Structure

```
app/
├── Http/Controllers/     # Page controllers
├── Http/Services/       # Business logic layer
├── Http/Requests/       # Form validation
├── DTO/                 # Data transfer objects
├── Models/              # Database models
├── Enums/               # PHP 8+ enums
└── Mail/                # Email templates

resources/
├── views/               # Blade templates
├── lang/               # Translation files
└── css/                # TailwindCSS styles

database/
├── migrations/         # Database schema
├── seeders/           # Sample data
└── database.sqlite    # SQLite database file
```

## 🔧 Development

### Code Quality

```bash
# Static analysis (PHPStan Level 9)
./vendor/bin/phpstan analyse --level=9

# Code formatting
./vendor/bin/pint

# Run tests
./vendor/bin/phpunit
```

### Performance Commands

```bash
# Cache management
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Response cache (spatie/laravel-responsecache)
php artisan responsecache:clear
```

## 📱 Features

### Contact Form System
- Professional appointment booking
- Email notifications to practice
- Enum-driven contact reasons
- GDPR-compliant with soft deletes

### FAQ System
- Comprehensive patient Q&A
- Category-based organization
- Accordion interface with accessibility
- Reduces administrative burden

### Team Management
- Multilingual team profiles
- Performance-optimized caching
- Professional photography support
- Role-based information display

### Performance Optimization
- **Response Caching**: Full-page caching (24-hour TTL)
- **Content Caching**: Practice data, services, team, FAQ
- **Asset Optimization**: CSS/JS minification and tree-shaking
- **Locale-Specific**: Cached translations per language

## 🛡️ Security & Quality

- **PHPStan Level 9**: Strict type safety throughout
- **CSRF Protection**: Laravel's built-in CSRF tokens
- **Input Validation**: Comprehensive form validation
- **SQL Injection Prevention**: Eloquent ORM with parameterized queries
- **XSS Protection**: Blade template escaping

## 📧 Email Configuration

Configure SMTP settings in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS="praxis@example.com"
MAIL_PRACTICE_EMAIL="praxis@example.com"
```

## 🚀 Deployment

### Production Setup

1. **Environment**: Set `APP_ENV=production` and `APP_DEBUG=false`
2. **Database**: SQLite file automatically created on first run
3. **Assets**: Run `npm run build` for optimized assets
4. **Caching**: Enable all Laravel caches for optimal performance
5. **HTTPS**: Configure SSL certificate for secure operation

### Performance Optimization

```bash
# Production optimization
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📚 Documentation

- **Full Documentation**: See `CLAUDE.md` for comprehensive development guide
- **API Reference**: See `docs/API_REFERENCE.md`
- **Architecture**: See `docs/system-architecture-overview.md`
- **Database Schema**: See `docs/database-schema-documentation.md`

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Ensure PHPStan Level 9 compliance
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

Built with ❤️ for German healthcare professionals