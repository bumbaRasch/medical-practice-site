# 🔒 Security & Structured Logging Guide

## Overview

The medical practice website implements enterprise-grade security headers and structured JSON logging with context-aware metadata for comprehensive monitoring, security, and compliance.

## 🛡️ Security Headers Implementation

### SecurityHeaders Middleware

**Purpose**: Implements comprehensive security headers following OWASP recommendations and healthcare security best practices.

**Location**: `app/Http/Middleware/SecurityHeaders.php`  
**Registration**: Global middleware in `bootstrap/app.php`

### Implemented Security Headers

#### 🔐 Transport Security
```http
Strict-Transport-Security: max-age=31536000; includeSubDomains; preload
```
- **Purpose**: Enforce HTTPS connections for 1 year
- **Features**: Includes subdomains and preload list eligible
- **Activation**: Only on HTTPS requests

#### 🛡️ Content Security Policy (CSP)
```http
Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://unpkg.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; img-src 'self' data: https: blob:; font-src 'self' https://fonts.gstatic.com; connect-src 'self' https://api.openstreetmap.org; media-src 'self'; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'; block-all-mixed-content; upgrade-insecure-requests
```

**CSP Policies by Source**:
- **Scripts**: Same origin + inline (for Blade) + Leaflet.js CDN
- **Styles**: Same origin + inline (for Tailwind) + Google Fonts
- **Images**: Same origin + data URLs + HTTPS (for maps/photos)
- **Fonts**: Same origin + Google Fonts
- **Connections**: Same origin + OpenStreetMap API
- **Objects**: Blocked entirely (security best practice)
- **Forms**: Same origin only (contact form security)

#### 🚫 Anti-Clickjacking
```http
X-Frame-Options: DENY
X-Content-Type-Options: nosniff
```
- **X-Frame-Options**: Prevents embedding in frames/iframes
- **X-Content-Type-Options**: Prevents MIME type sniffing attacks

#### 🔍 XSS Protection
```http
X-XSS-Protection: 1; mode=block
X-DNS-Prefetch-Control: off
```
- **XSS Protection**: Legacy XSS filter activation
- **DNS Prefetch**: Disabled for privacy

#### 📄 Referrer Policy
```http
Referrer-Policy: strict-origin-when-cross-origin
```
- **Purpose**: Protect patient privacy in referrer headers
- **Behavior**: Only send referrer for same-origin requests

#### 🎛️ Permissions Policy
```http
Permissions-Policy: accelerometer=(), camera=(), geolocation=(self), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=(), fullscreen=(self), picture-in-picture=()
```

**Feature Controls**:
- **Disabled**: Camera, microphone, accelerometer, gyroscope, payment API
- **Enabled**: Geolocation (practice location), fullscreen (maps)

#### 🏥 Medical Practice Headers
```http
X-Medical-Practice: true
X-Patient-Privacy: protected
X-Security-Contact: security@domain.com
Content-Language: de|en
```

**Sensitive Page Cache Control**:
```http
Cache-Control: no-cache, no-store, must-revalidate, private
Pragma: no-cache
Expires: 0
```
- **Applied to**: Contact form and form submission pages
- **Purpose**: Prevent caching of patient data

### Environment-Based Configuration

#### Development
- **CSP Mode**: Report-only for testing
- **Eval Scripts**: Allowed for Vite HMR
- **WebSocket**: Allowed for development tools

#### Production
- **CSP Mode**: Enforced
- **HSTS**: Full enforcement
- **Upgrade Insecure**: Force HTTPS

---

## 📝 Structured Logging System

### Architecture Overview

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│  Application    │    │   MedicalLogger │    │  JSON Formatter │
│    Events       │───▶│    Methods      │───▶│   Structured    │
│                 │    │                 │    │     Output      │
└─────────────────┘    └─────────────────┘    └─────────────────┘
                                │
                                ▼
                       ┌─────────────────┐
                       │  Log Channels   │
                       │ • contact_form  │
                       │ • security      │
                       │ • performance   │
                       │ • audit         │
                       └─────────────────┘
```

### JSON Log Structure

**Standard JSON Format**:
```json
{
  "timestamp": "2025-07-19T10:30:00+00:00",
  "level": "info",
  "level_name": "INFO",
  "message": "Contact form submitted successfully",
  "channel": "contact_form",
  "application": {
    "name": "Medical Practice Website",
    "environment": "production",
    "version": "1.0.0",
    "locale": "de"
  },
  "request": {
    "method": "POST",
    "url": "https://practice.com/form/request",
    "path": "form/request",
    "route": "form.request.submit",
    "ip": "hashed_abc12345",
    "user_agent": "Mozilla/5.0...",
    "is_secure": true,
    "session_id": "session_xyz67890"
  },
  "system": {
    "hostname": "web-server-01",
    "process_id": 1234,
    "memory_usage": {
      "current": "45.2MB",
      "peak": "52.1MB"
    },
    "php_version": "8.2.15",
    "laravel_version": "12.0.0"
  },
  "medical_context": {
    "practice_type": "general_medicine",
    "patient_privacy": "protected",
    "gdpr_compliant": true,
    "component": "contact_form",
    "patient_interaction": true
  },
  "context": {
    "event": "contact_form_submitted",
    "request_id": 123,
    "has_preferred_datetime": true,
    "contact_reason": "general_inquiry",
    "locale": "de"
  },
  "trace_id": "trace_abc123def456"
}
```

### Log Channels & Retention

#### 📞 Contact Form Channel
- **File**: `logs/contact-form-YYYY-MM-DD.log`
- **Retention**: 90 days (extended for patient contacts)
- **Level**: INFO and above
- **Purpose**: Patient interaction tracking

#### 🔒 Security Channel
- **File**: `logs/security-YYYY-MM-DD.log`
- **Retention**: 365 days (compliance requirement)
- **Level**: WARNING and above
- **Purpose**: Security event monitoring

#### ⚡ Performance Channel
- **File**: `logs/performance-YYYY-MM-DD.log`
- **Retention**: 30 days
- **Level**: INFO and above
- **Purpose**: Application performance monitoring

#### 📋 Audit Channel
- **File**: `logs/audit-YYYY-MM-DD.log`
- **Retention**: 2555 days (7 years for medical compliance)
- **Level**: INFO and above
- **Purpose**: Compliance and audit trail

#### 🏥 Medical Structured Channel
- **File**: `logs/medical-practice-YYYY-MM-DD.log`
- **Retention**: 30 days
- **Level**: DEBUG and above
- **Purpose**: General application logging

### MedicalLogger Methods

#### Patient Interactions
```php
// Contact form submission
MedicalLogger::contactFormSubmitted(int $requestId, string $email, array $context = []);

// Form submission failure
MedicalLogger::contactFormFailed(string $error, array $input = [], array $context = []);

// Email notifications
MedicalLogger::emailNotification(string $event, string $recipient, array $context = []);
```

#### Security Events
```php
// Security incidents
MedicalLogger::securityEvent(string $event, string $severity = 'warning', array $context = []);

// Validation errors
MedicalLogger::validationError(string $field, string $rule, mixed $value = null, array $context = []);
```

#### Performance Monitoring
```php
// Performance metrics
MedicalLogger::performanceMetric(string $operation, float $duration, array $metrics = []);

// Database operations
MedicalLogger::databaseOperation(string $operation, string $table, float $duration, array $context = []);

// Cache operations
MedicalLogger::cacheOperation(string $operation, string $key, bool $success, array $context = []);
```

#### Compliance & Audit
```php
// Audit trail
MedicalLogger::auditEvent(string $action, string $resource, array $context = []);

// User actions
MedicalLogger::userAction(string $action, array $context = []);

// System health
MedicalLogger::healthCheck(string $component, bool $healthy, array $metrics = []);
```

### Privacy & GDPR Compliance

#### Automatic Data Filtering
**Sensitive Data Filtered**:
- Patient information (email, phone, names, messages)
- Authentication tokens and sessions
- System credentials and API keys
- Medical data references

#### IP Address Hashing
```php
// Production: Hashed for privacy
"ip": "hashed_abc12345"

// Development: Partially masked
"ip": "192.168.***"
```

#### Email Address Protection
```php
// Production: Hashed
"patient_email": "email_xyz67890"

// Development: Partially masked
"patient_email": "ma***@example.com"
```

### Context-Aware Metadata

#### Request Context
- HTTP method, URL, route name
- User agent analysis (mobile/desktop/bot)
- Session correlation (hashed)
- Response status and size

#### Medical Practice Context
- Practice type and specialty
- Patient interaction flags
- Privacy compliance indicators
- Component identification

#### System Context
- Server hostname and process ID
- Memory usage and performance
- PHP and Laravel versions
- Environment identification

#### Performance Context
- Response time measurements
- Memory usage tracking
- Database query counts
- Cache hit/miss rates

---

## 🔍 Performance Monitoring

### MonitorPerformance Middleware

**Purpose**: Track request performance with structured logging  
**Location**: `app/Http/Middleware/MonitorPerformance.php`  
**Registration**: Available as alias `performance.monitor`

### Performance Metrics

#### Response Time Tracking
- **Excellent**: < 500ms
- **Good**: 500ms - 1s
- **Acceptable**: 1s - 2s
- **Slow**: 2s - 5s (logged as warning)
- **Critical**: > 5s (logged as critical security event)

#### Memory Usage Monitoring
- Current memory usage per request
- Peak memory usage tracking
- Memory difference calculation
- Development headers for debugging

#### Database Performance
- Query count tracking
- Slow query detection
- Database operation timing
- Connection performance

### Development Headers

When `APP_ENV=local`:
```http
X-Response-Time: 245.67ms
X-Memory-Usage: 12.34MB
X-Peak-Memory: 15.67MB
X-Query-Count: 8
```

---

## 🎯 Log Analysis & Monitoring

### Key Performance Indicators

#### Contact Form Metrics
```bash
# Success rate
grep '"event":"contact_form_submitted"' logs/contact-form-*.log | wc -l

# Failure rate
grep '"event":"contact_form_failed"' logs/contact-form-*.log | wc -l

# Average response time
grep '"operation":"post_contact_form_submit"' logs/performance-*.log | \
  jq '.duration_ms' | awk '{sum+=$1} END {print sum/NR}'
```

#### Security Monitoring
```bash
# Security events by severity
grep '"event":"security_event"' logs/security-*.log | \
  jq -r '.severity' | sort | uniq -c

# Failed login attempts (if implemented)
grep '"security_event":"authentication_failed"' logs/security-*.log | wc -l

# CSRF token mismatches
grep '"security_event":"csrf_token_mismatch"' logs/security-*.log | wc -l
```

#### Performance Analysis
```bash
# Slow requests (>2s)
grep '"slow_threshold_exceeded":true' logs/performance-*.log | \
  jq -r '.request_path' | sort | uniq -c

# Memory usage trends
grep '"event":"performance_metric"' logs/performance-*.log | \
  jq '.memory_used_mb' | sort -n | tail -10

# Critical performance issues
grep '"impact":"user_experience_severely_degraded"' logs/performance-*.log
```

### Log Shipping & Analysis

#### ELK Stack Integration
```yaml
# Example Filebeat configuration
filebeat.inputs:
- type: log
  paths:
    - /var/www/storage/logs/contact-form-*.log
    - /var/www/storage/logs/security-*.log
    - /var/www/storage/logs/performance-*.log
  fields:
    service: medical-practice
    environment: production
  fields_under_root: true
  json.keys_under_root: true
```

#### Splunk Configuration
```conf
[monitor:///var/www/storage/logs/*.log]
sourcetype = medical_practice_json
index = medical_practice
KV_MODE = json
SHOULD_LINEMERGE = false
```

### Alerting Rules

#### Critical Alerts
```yaml
# Contact form down
- alert: ContactFormFailures
  expr: rate(contact_form_failed[5m]) > 0.1
  annotations:
    summary: "High contact form failure rate"
    description: "Contact form failures exceed 10% in 5 minutes"

# Performance degradation
- alert: SlowResponses
  expr: rate(slow_request_detected[5m]) > 0.05
  annotations:
    summary: "High slow request rate"
    description: "Slow requests exceed 5% in 5 minutes"

# Security incidents
- alert: SecurityEvents
  expr: rate(security_event{severity="critical"}[5m]) > 0
  annotations:
    summary: "Critical security event detected"
    description: "Critical security event requires immediate attention"
```

---

## 🔧 Configuration & Setup

### Environment Configuration

```env
# Logging Channels
LOG_CHANNEL=json_stack
LOG_DAILY_DAYS=30

# Security Logging
LOG_SECURITY_LEVEL=warning
LOG_SECURITY_DAYS=365

# Performance Logging
LOG_PERFORMANCE_LEVEL=info
LOG_PERFORMANCE_DAYS=30

# Audit Logging (Medical Compliance)
LOG_AUDIT_DAYS=2555  # 7 years
```

### Log Rotation Configuration

#### Logrotate Example
```conf
/var/www/storage/logs/*.log {
    daily
    rotate 30
    compress
    delaycompress
    notifempty
    create 0644 www-data www-data
    postrotate
        /usr/bin/supervisorctl restart laravel-worker
    endscript
}

# Extended retention for audit logs
/var/www/storage/logs/audit-*.log {
    daily
    rotate 2555
    compress
    delaycompress
    notifempty
    create 0644 www-data www-data
}
```

### Monitoring Dashboard Queries

#### Grafana Dashboard Panels

**Contact Form Success Rate**:
```sql
SELECT 
  $__timeGroup(timestamp,'1h'),
  count(*) as submissions,
  sum(case when event='contact_form_submitted' then 1 else 0 end) as successful,
  sum(case when event='contact_form_failed' then 1 else 0 end) as failed
FROM logs 
WHERE $__timeFilter(timestamp)
GROUP BY 1
ORDER BY 1
```

**Performance Metrics**:
```sql
SELECT 
  $__timeGroup(timestamp,'5m'),
  avg(duration_ms) as avg_response_time,
  max(duration_ms) as max_response_time,
  percentile_cont(0.95) within group (order by duration_ms) as p95_response_time
FROM logs 
WHERE event='performance_metric' AND $__timeFilter(timestamp)
GROUP BY 1
ORDER BY 1
```

---

## 🚨 Incident Response

### Log-Based Incident Detection

#### High Contact Form Failure Rate
1. **Detection**: >10% failures in 5 minutes
2. **Investigation**: Check `contact-form` logs for error patterns
3. **Response**: Identify root cause (validation, email, database)
4. **Resolution**: Fix underlying issue and monitor recovery

#### Performance Degradation
1. **Detection**: >5% slow requests in 5 minutes
2. **Investigation**: Check `performance` logs for bottlenecks
3. **Response**: Identify slow operations and optimization opportunities
4. **Resolution**: Optimize code, database queries, or infrastructure

#### Security Incidents
1. **Detection**: Critical security events
2. **Investigation**: Review `security` logs for attack patterns
3. **Response**: Implement immediate protective measures
4. **Resolution**: Patch vulnerabilities and strengthen defenses

### Forensic Analysis

#### Patient Data Access Investigation
```bash
# Search for specific patient interactions
grep '"request_id":123' logs/contact-form-*.log logs/audit-*.log

# Timeline of events for a session
grep '"session_id":"session_xyz67890"' logs/*.log | \
  jq -r '[.timestamp, .event, .message] | @csv' | \
  sort
```

#### Security Incident Timeline
```bash
# All security events in timeframe
grep '"event":"security_event"' logs/security-*.log | \
  jq -r 'select(.timestamp >= "2025-07-19T10:00:00" and .timestamp <= "2025-07-19T11:00:00")' | \
  jq -r '[.timestamp, .security_event, .severity] | @csv' | \
  sort
```

---

This comprehensive security and logging implementation ensures the medical practice website maintains enterprise-grade security, comprehensive monitoring, and full compliance with healthcare data protection requirements while providing actionable insights for continuous improvement.