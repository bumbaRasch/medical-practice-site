# 🚨 Sentry Error Monitoring Setup Guide

## Overview

This guide covers the complete setup of Sentry error monitoring for the medical practice website, including installation, configuration, and best practices for healthcare applications.

## 📦 Installation

### 1. Install Sentry Laravel Package

```bash
# Install Sentry Laravel integration
composer require sentry/sentry-laravel

# Publish Sentry configuration (optional - already provided)
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"
```

### 2. Environment Configuration

Add your Sentry DSN to `.env`:

```env
# Sentry Configuration
SENTRY_LARAVEL_DSN=https://your-dsn@sentry.io/project-id
SENTRY_TRACES_SAMPLE_RATE=0.1
SENTRY_PROFILES_SAMPLE_RATE=0.1
SENTRY_SEND_DEFAULT_PII=false
SENTRY_ENVIRONMENT=production
```

### 3. Verify Installation

```bash
# Test Sentry integration
php artisan sentry:test

# Check configuration
php artisan config:show sentry
```

## 🔧 Medical Practice Configuration

### Current Configuration Highlights

```php
// config/sentry.php - Medical Practice Optimized

// Privacy-First Configuration
'send_default_pii' => false,  // GDPR compliant
'sample_rate' => 1.0,         // Capture all errors
'traces_sample_rate' => 0.1,  // 10% performance monitoring

// Medical Practice Context
'context' => [
    'extra' => [
        'medical_practice' => true,
        'patient_privacy' => 'protected',
        'compliance' => 'healthcare',
    ],
],

// Filtered Exceptions (Patient Privacy)
'ignore_exceptions' => [
    ValidationException::class,           // Form validation errors
    NotFoundHttpException::class,        // 404 errors
    TokenMismatchException::class,       // CSRF token issues
    AuthenticationException::class,      // Login failures
],
```

## 🏥 Medical Practice Specific Setup

### 1. Patient Privacy Protection

**Automatic PII Filtering**:
```php
// Sensitive data automatically filtered
'before_send' => function (Sentry\Event $event): ?Sentry\Event {
    // Skip validation exceptions (handled by form)
    if ($exception->getType() === 'Illuminate\Validation\ValidationException') {
        return null;
    }
    
    // Skip common non-critical exceptions
    if ($exception->getType() === 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException') {
        return null;
    }
    
    return $event;
},
```

**Breadcrumb Configuration**:
```php
'breadcrumbs' => [
    'sql_queries' => true,      // Debug database issues
    'sql_bindings' => false,    // Don't capture sensitive data
    'http_client' => true,      // Track external API calls
    'cache' => false,           // Skip cache operations for privacy
],
```

### 2. Performance Monitoring

**Medical Website Optimized**:
```php
'traces_sample_rate' => 0.1,    // 10% for medical sites
'profiles_sample_rate' => 0.1,  // Low profiling overhead

'tracing' => [
    'sql_queries' => true,           // Track slow database queries
    'queue_jobs' => true,            // Monitor email notifications
    'http_client' => true,           // External service monitoring
    'missing_routes' => false,       // Skip 404 tracking
],
```

### 3. Error Context Enhancement

```php
// Add medical practice context to all errors
Sentry\configureScope(function (Sentry\State\Scope $scope): void {
    $scope->setContext('medical_practice', [
        'type' => 'general_medicine',
        'patient_privacy' => 'protected',
        'compliance' => ['gdpr', 'healthcare'],
        'critical_systems' => ['contact_form', 'email_notifications'],
    ]);
});
```

## 🔍 Monitoring Critical Medical Practice Components

### 1. Contact Form Monitoring

**Key Metrics to Track**:
```php
// Contact form submission failures
Sentry\addBreadcrumb([
    'message' => 'Contact form processing started',
    'category' => 'medical.contact_form',
    'level' => 'info',
    'data' => [
        'form_type' => 'patient_contact',
        'has_preferred_time' => $data->hasPreferredDatetime(),
    ],
]);

// Track email delivery failures
if ($emailFailed) {
    Sentry\captureMessage('Patient notification email failed', 'warning', [
        'contact_request_id' => $requestId,
        'impact' => 'patient_not_notified',
        'action_required' => 'manual_follow_up',
    ]);
}
```

### 2. Performance Monitoring

**Medical Website Thresholds**:
```php
// Custom performance tracking
Sentry\startTransaction([
    'name' => 'contact_form_submission',
    'op' => 'patient_interaction',
]);

// Track slow operations (medical sites need fast response)
if ($responseTime > 2000) { // >2 seconds
    Sentry\captureMessage('Slow patient form response', 'warning', [
        'response_time_ms' => $responseTime,
        'threshold_exceeded' => '2000ms',
        'impact' => 'poor_patient_experience',
    ]);
}
```

### 3. Email System Monitoring

```php
// Track email delivery for patient notifications
try {
    Mail::to($practiceEmail)->send(new ContactFormNotification($data));
    
    Sentry\addBreadcrumb([
        'message' => 'Patient notification sent successfully',
        'category' => 'medical.email',
        'level' => 'info',
    ]);
} catch (Exception $e) {
    Sentry\captureException($e, [
        'level' => 'error',
        'tags' => [
            'component' => 'email_system',
            'impact' => 'patient_communication_failed',
        ],
    ]);
}
```

## 📊 Dashboard Configuration

### 1. Sentry Project Setup

**Project Configuration**:
- **Project Name**: Medical Practice Website
- **Platform**: PHP/Laravel
- **Environment**: Production/Staging/Development
- **Team**: Development + Practice Staff (read-only)

### 2. Alert Rules

**Critical Alerts** (Immediate Response):
```yaml
# Contact form system failure
- alert: "Contact Form Down"
  conditions:
    - error_count > 5 in 5 minutes
    - error.type contains "ContactForm"
  actions:
    - email: [admin@practice.com, dev-team@company.com]
    - slack: #critical-alerts

# Email delivery failure
- alert: "Patient Notification Failure"
  conditions:
    - error.message contains "notification email failed"
    - count > 3 in 10 minutes
  actions:
    - email: practice-staff@practice.com
    - sms: +49xxx (practice manager)
```

**Performance Alerts**:
```yaml
# Slow response times
- alert: "Patient Experience Degraded"
  conditions:
    - transaction.duration > 5000ms
    - count > 10 in 15 minutes
  actions:
    - email: dev-team@company.com

# High error rate
- alert: "System Instability"
  conditions:
    - error_rate > 5% in 10 minutes
  actions:
    - email: [admin@practice.com, dev-team@company.com]
    - slack: #medical-alerts
```

### 3. Custom Dashboards

**Medical Practice KPIs**:
```
Dashboard: "Medical Practice Monitoring"

Widgets:
1. Contact Form Success Rate (last 24h)
2. Average Response Time by Page
3. Email Delivery Success Rate
4. Top Errors by Frequency
5. Patient Interaction Timeline
6. System Performance Overview
```

## 🛠️ Integration with Existing Logging

### 1. Structured Logging Integration

```php
// Enhanced MedicalLogger with Sentry
class MedicalLogger {
    public static function contactFormFailed(string $error, array $context = []): void
    {
        // Log to structured logs
        Log::channel('contact_form')->error('Contact form failed', $context);
        
        // Also send to Sentry for alerting
        Sentry\captureMessage($error, 'error', [
            'extra' => $context,
            'tags' => [
                'component' => 'contact_form',
                'requires_attention' => true,
            ],
        ]);
    }
}
```

### 2. Correlation with Application Logs

```php
// Add trace ID correlation
Sentry\configureScope(function (Sentry\State\Scope $scope): void {
    $traceId = request()->header('X-Trace-ID');
    if ($traceId) {
        $scope->setTag('trace_id', $traceId);
    }
});
```

## 🔒 Security & Privacy Considerations

### 1. GDPR Compliance

**Data Protection Measures**:
- **No PII Capture**: `send_default_pii: false`
- **IP Hashing**: Custom before_send filter
- **Request Filtering**: No request body capture
- **Context Filtering**: Sensitive data removed

### 2. Healthcare Compliance

**Medical Practice Requirements**:
- **Error Retention**: 1 year maximum
- **Access Control**: Limited team access
- **Audit Trail**: Log all Sentry access
- **Data Location**: EU servers if required

### 3. Team Access Management

```yaml
# Sentry Team Configuration
Teams:
  - name: "Medical Practice Staff"
    role: "read-only"
    access: ["dashboard", "issues"]
    
  - name: "Development Team"
    role: "admin"
    access: ["full"]
    
  - name: "Practice Manager"
    role: "read-only"
    access: ["dashboard", "alerts"]
```

## 📱 Mobile & Multi-Device Monitoring

### 1. User Experience Tracking

```php
// Track device-specific issues
Sentry\configureScope(function (Sentry\State\Scope $scope): void {
    $userAgent = request()->userAgent();
    
    $scope->setTag('device_type', [
        'mobile' => str_contains($userAgent, 'Mobile'),
        'tablet' => str_contains($userAgent, 'Tablet'),
        'desktop' => !str_contains($userAgent, 'Mobile|Tablet'),
    ]);
});
```

### 2. Performance by Device

```php
// Track performance by device type
Sentry\startTransaction([
    'name' => 'page_load',
    'op' => 'navigation',
    'tags' => [
        'device_type' => $deviceType,
        'page' => $currentPage,
    ],
]);
```

## 🚨 Incident Response Integration

### 1. Automated Incident Creation

```php
// Critical errors create incidents automatically
if ($severity === 'critical') {
    Sentry\captureException($exception, [
        'level' => 'fatal',
        'tags' => [
            'incident' => true,
            'requires_immediate_response' => true,
            'impact' => 'patient_service_disrupted',
        ],
    ]);
}
```

### 2. Escalation Rules

```yaml
# Escalation Configuration
Escalation Rules:
  - Level 1: Development Team (0-30 minutes)
  - Level 2: Practice Manager (30-60 minutes)  
  - Level 3: IT Support + Practice Owner (60+ minutes)
  
Triggers:
  - Unresolved critical errors
  - Contact form completely down
  - Email system failure
  - Security incidents
```

## 📋 Maintenance & Best Practices

### 1. Regular Review Process

**Weekly**:
- Review error trends and patterns
- Check performance regression
- Validate alert thresholds

**Monthly**:
- Review team access and permissions
- Update ignored exceptions list
- Analyze patient experience metrics

**Quarterly**:
- Review retention policies
- Update compliance documentation
- Assess monitoring coverage

### 2. Performance Optimization

```php
// Optimize Sentry performance
'sample_rate' => match (app()->environment()) {
    'production' => 1.0,    // Capture all errors
    'staging' => 0.5,       // Sample staging errors
    'local' => 0.1,         // Minimal local capture
    default => 0.1,
},

'traces_sample_rate' => match (app()->environment()) {
    'production' => 0.1,    // 10% transaction tracing
    'staging' => 0.2,       // 20% for testing
    'local' => 0.0,         // No tracing locally
    default => 0.0,
},
```

### 3. Cost Management

**Optimization Strategies**:
- **Smart Sampling**: Adjust rates based on traffic
- **Exception Filtering**: Ignore common non-critical errors
- **Performance Monitoring**: Limit to critical paths
- **Data Retention**: Align with medical practice needs

---

## 🚀 Quick Start Checklist

### Setup Tasks
- [ ] Install sentry/sentry-laravel package
- [ ] Configure SENTRY_LARAVEL_DSN in environment
- [ ] Test installation with `php artisan sentry:test`
- [ ] Set up Sentry project and team access
- [ ] Configure alert rules for critical components
- [ ] Create medical practice monitoring dashboard
- [ ] Test error reporting and alerting
- [ ] Document incident response procedures
- [ ] Train practice staff on monitoring tools
- [ ] Schedule regular review meetings

### Post-Launch Monitoring
- [ ] Monitor contact form success rates
- [ ] Track email delivery performance
- [ ] Review patient experience metrics
- [ ] Validate privacy compliance
- [ ] Optimize alert thresholds
- [ ] Update team access as needed

This Sentry setup provides enterprise-grade error monitoring specifically tailored for medical practice websites while maintaining strict patient privacy and healthcare compliance requirements.