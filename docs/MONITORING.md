# 🔍 Application Monitoring Guide

## Overview

This medical practice website includes comprehensive monitoring through Laravel Telescope and Sentry integration for development, staging, and production environments.

## Monitoring Architecture

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Development   │    │     Staging     │    │   Production    │
│                 │    │                 │    │                 │
│ • Telescope     │    │ • Telescope     │    │ • Sentry Only   │
│ • Full Logging  │    │ • Sentry        │    │ • Health Check  │
│ • Performance   │    │ • Sampling      │    │ • Alerts        │
│   Headers       │    │                 │    │                 │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

## 🔭 Laravel Telescope

**Purpose**: Development and staging environment monitoring  
**Access**: `/telescope` (restricted by environment)  
**Installation**: Included in dev dependencies

### Features
- **Request Monitoring**: Complete HTTP request/response tracking
- **Database Analysis**: Query performance and N+1 detection
- **Mail Tracking**: Email sending verification and content preview
- **Cache Operations**: Cache hit/miss tracking and performance
- **Exception Tracking**: Detailed error reporting with stack traces
- **Performance Metrics**: Response times and memory usage

### Configuration
```php
// config/telescope.php
'watchers' => [
    Watchers\QueryWatcher::class => [
        'enabled' => env('TELESCOPE_QUERY_WATCHER', true),
        'slow' => 100, // Log queries slower than 100ms
    ],
    Watchers\RequestWatcher::class => [
        'enabled' => env('TELESCOPE_REQUEST_WATCHER', true),
        'size_limit' => 64, // Response size limit in KB
    ],
    // ... other watchers
],
```

### Security Features
- **Environment Restriction**: Only enabled in local/staging
- **Access Control**: Gate-based authentication
- **Data Filtering**: Sensitive request parameters hidden
- **Sampling**: Configurable data collection rates

## 🚨 Sentry Error Tracking

**Purpose**: Production-ready error monitoring and performance tracking  
**Integration**: `sentry/sentry-laravel` package

### Key Features
- **Real-time Error Tracking**: Immediate notification of application errors
- **Performance Monitoring**: Transaction tracing and slow query detection
- **Release Tracking**: Deploy-based error correlation
- **Custom Context**: Medical practice specific error context
- **GDPR Compliance**: No PII data collection by default

### Configuration Highlights
```php
// config/sentry.php
'sample_rate' => 1.0,              // 100% error capture
'traces_sample_rate' => 0.1,       // 10% performance monitoring
'send_default_pii' => false,       // GDPR compliant
'ignore_exceptions' => [
    ValidationException::class,     // Form validation errors
    NotFoundHttpException::class,   // 404 errors
    TokenMismatchException::class,  // CSRF token issues
],
```

### Medical Practice Context
- **Contact Form Errors**: Detailed form submission failure tracking
- **Email Delivery**: Mail sending failure monitoring
- **Database Issues**: Patient data access problem detection
- **Performance Issues**: Slow appointment booking detection

## 🏥 Health Check System

**Endpoint**: `GET /api/health`  
**Purpose**: External monitoring and uptime services  
**Controller**: `HealthCheckController`

### Health Check Response
```json
{
  "status": "healthy|unhealthy",
  "timestamp": "2025-07-19T10:30:00.000Z",
  "application": {
    "name": "Medical Practice Website",
    "version": "1.0.0",
    "environment": "production"
  },
  "checks": {
    "database": {
      "status": "healthy",
      "message": "Database connection successful"
    },
    "cache": {
      "status": "healthy",
      "message": "Cache is working"
    },
    "disk": {
      "status": "warning",
      "message": "Disk usage is 85% (warning)"
    }
  }
}
```

### Health Check Components
- **Database Connectivity**: Contact form data access validation
- **Cache Operations**: Practice data caching verification
- **Disk Space**: Storage availability monitoring
- **Memory Usage**: Application resource monitoring

## 📊 Performance Monitoring

### Performance Middleware
`MonitorPerformance` middleware tracks:
- **Response Time**: Request processing duration
- **Memory Usage**: Per-request memory consumption
- **Slow Request Detection**: Automatic logging of >2s responses
- **Development Headers**: Performance data in response headers

### Key Performance Metrics

#### Contact Form Performance
- **Form Submission**: <500ms target response time
- **Email Delivery**: <2s for notification sending
- **Database Operations**: <100ms for form data persistence
- **Validation**: <50ms for form field validation

#### Page Load Performance
- **Homepage**: <1s cached, <3s uncached
- **Contact Page**: <800ms (includes form assets)
- **FAQ Page**: <600ms (cached content)
- **Team Page**: <700ms (localized content)

## 🛠️ Monitoring Commands

### Status Check Command
```bash
php artisan monitoring:status
```

**Output Example**:
```
🔍 Medical Practice Monitoring Status

📡 Telescope Status:
  ✅ Telescope is enabled
  📊 Total entries: 1,247

🚨 Sentry Status:
  ✅ Sentry DSN configured
  🔗 Environment: production

🗄️ Database Status:
  ✅ Database connection successful
  📝 Form requests: 89
  📋 Contact reasons: 8

💾 Cache Status:
  ✅ Cache is working

✅ Monitoring status check complete
```

### Additional Commands
```bash
# Clear Telescope data (development)
php artisan telescope:clear

# Test Sentry integration
php artisan sentry:test

# Check application health
curl http://localhost/api/health

# Monitor performance in real-time
php artisan pail --filter=slow
```

## 🎯 Key Metrics for Medical Practice

### Contact Form Metrics
- **Submission Success Rate**: Target >95%
- **Validation Error Rate**: Monitor <10%
- **Email Delivery Success**: Target >99%
- **Form Completion Time**: Average user completion tracking

### Patient Experience Metrics
- **Page Load Speed**: <3s for all pages
- **Mobile Performance**: Core Web Vitals compliance
- **Accessibility**: WCAG 2.1 AA compliance monitoring
- **Localization**: German/English translation accuracy

### System Health Metrics
- **Database Response**: <100ms average query time
- **Cache Hit Rate**: >80% for practice data
- **Memory Usage**: <512MB average per request
- **Error Rate**: <0.1% application errors

## 🚨 Alert Configuration

### Critical Alerts (Immediate Response)
- **Application Errors**: Any unhandled exception
- **Database Failures**: Connection timeouts or errors
- **Email Delivery Failures**: Patient notification failures
- **Health Check Failures**: System unavailability

### Warning Alerts (Monitor)
- **Slow Queries**: Database queries >500ms
- **High Memory Usage**: >1GB per request
- **Disk Space**: >80% usage
- **Form Errors**: >20 validation failures/hour

### Performance Alerts
- **Response Time**: >5s for any page
- **Cache Miss Rate**: <60% hit rate
- **Contact Form Issues**: >10 failures/hour
- **Mobile Performance**: Core Web Vitals degradation

## 📱 External Monitoring Setup

### Recommended Services
1. **Uptime Monitoring**: Pingdom, UptimeRobot, or StatusCake
2. **Performance Monitoring**: GTmetrix, WebPageTest
3. **SSL Monitoring**: SSL certificate expiration tracking
4. **Domain Monitoring**: DNS resolution and domain expiry

### Monitoring Endpoints
```
Health Check: https://your-domain.com/api/health
Homepage: https://your-domain.com/
Contact Form: https://your-domain.com/kontakt
```

### Monitoring Frequency
- **Health Check**: Every 1 minute
- **Full Page Tests**: Every 5 minutes
- **Performance Tests**: Every 15 minutes
- **SSL Check**: Daily

## 🔒 Security Monitoring

### Security Events to Monitor
- **Failed Login Attempts**: Unusual access patterns
- **CSRF Token Failures**: Potential bot attacks
- **SQL Injection Attempts**: Malicious query detection
- **File Upload Abuse**: Unexpected file uploads

### Privacy Compliance
- **GDPR Compliance**: No PII in error reports
- **Data Retention**: Monitoring data cleanup policies
- **Access Logging**: Administrative access tracking
- **Patient Data**: Secure handling verification

## 🚀 Setup Instructions

### 1. Install Monitoring Packages
```bash
composer require --dev laravel/telescope
composer require sentry/sentry-laravel
```

### 2. Run Setup Script
```bash
./scripts/setup-monitoring.sh
```

### 3. Configure Environment Variables
```env
# Telescope (Development/Staging)
TELESCOPE_ENABLED=true
TELESCOPE_PATH=telescope

# Sentry (All Environments)
SENTRY_LARAVEL_DSN=your-sentry-dsn-here
SENTRY_TRACES_SAMPLE_RATE=0.1
SENTRY_SEND_DEFAULT_PII=false

# Practice Configuration
MAIL_PRACTICE_EMAIL=praxis@example.com
```

### 4. Database Migration
```bash
php artisan telescope:install
php artisan migrate
```

### 5. Verify Installation
```bash
php artisan monitoring:status
```

## 📋 Production Deployment Checklist

### Pre-Deployment
- [ ] Sentry DSN configured and tested
- [ ] Telescope disabled in production
- [ ] Health check endpoint tested
- [ ] Performance baselines established
- [ ] Alert thresholds configured

### Post-Deployment
- [ ] External uptime monitoring active
- [ ] Sentry receiving error reports
- [ ] Health check returning 200 status
- [ ] Performance within acceptable ranges
- [ ] Alert notifications working

### Ongoing Maintenance
- [ ] Weekly performance review
- [ ] Monthly error trend analysis
- [ ] Quarterly alert threshold review
- [ ] Semi-annual monitoring strategy review

## 🔧 Troubleshooting

### Common Issues

**Telescope Not Accessible**
```bash
# Check configuration
php artisan config:show telescope

# Verify database tables
php artisan migrate:status | grep telescope

# Check access gate
php artisan tinker
>>> Gate::allows('viewTelescope')
```

**Sentry Not Receiving Errors**
```bash
# Test Sentry connection
php artisan sentry:test

# Check DSN configuration
php artisan config:show sentry.dsn

# Verify sample rates
php artisan config:show sentry.sample_rate
```

**Health Check Failures**
```bash
# Test individual components
php artisan db:show
php artisan cache:status
df -h  # Check disk space
```

**Performance Issues**
```bash
# Check slow queries
php artisan telescope:clear && php artisan serve
# Visit /telescope/queries

# Monitor memory usage
php artisan pail --filter=memory
```

## 📚 Additional Resources

### Documentation Links
- [Laravel Telescope Documentation](https://laravel.com/docs/telescope)
- [Sentry Laravel Documentation](https://docs.sentry.io/platforms/php/guides/laravel/)
- [Medical Website Performance Best Practices](docs/PERFORMANCE.md)

### Medical Practice Specific Monitoring
- **Patient Privacy**: Ensure no medical data in logs
- **Compliance**: GDPR and healthcare regulation adherence
- **Availability**: High uptime requirements for patient access
- **Performance**: Fast response for emergency contact forms

---

*This monitoring setup ensures comprehensive oversight of the medical practice website while maintaining patient privacy and regulatory compliance.*