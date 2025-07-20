<?php

namespace App\Logging;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

/**
 * Medical Practice Context-Aware Logger
 * 
 * Provides structured logging methods with medical practice context
 * and automatic privacy compliance filtering.
 */
class MedicalLogger
{
    /**
     * Log patient contact form submission.
     *
     * @param array<string, mixed> $context
     */
    public static function contactFormSubmitted(int $requestId, string $email, array $context = []): void
    {
        Log::channel('contact_form')->info('Contact form submitted successfully', array_merge([
            'event' => 'contact_form_submitted',
            'request_id' => $requestId,
            'patient_email' => self::hashEmail($email),
            'component' => 'contact_form',
            'action' => 'submit',
            'outcome' => 'success',
            'patient_interaction' => true,
            'privacy_level' => 'protected',
        ], $context));
    }

    /**
     * Log contact form submission failure.
     *
     * @param array<string, mixed> $input
     * @param array<string, mixed> $context
     */
    public static function contactFormFailed(string $error, array $input = [], array $context = []): void
    {
        Log::channel('contact_form')->error('Contact form submission failed', array_merge([
            'event' => 'contact_form_failed',
            'error_message' => $error,
            'input_fields' => array_keys($input), // Only log field names, not values
            'component' => 'contact_form',
            'action' => 'submit',
            'outcome' => 'failure',
            'patient_interaction' => true,
            'privacy_level' => 'protected',
        ], $context));
    }

    /**
     * Log email notification events.
     *
     * @param array<string, mixed> $context
     */
    public static function emailNotification(string $event, string $recipient, array $context = []): void
    {
        Log::channel('contact_form')->info("Email notification: {$event}", array_merge([
            'event' => 'email_notification',
            'email_event' => $event,
            'recipient' => self::hashEmail($recipient),
            'component' => 'email_system',
            'action' => 'send_notification',
            'communication_type' => 'patient_notification',
            'privacy_level' => 'protected',
        ], $context));
    }

    /**
     * Log security events.
     *
     * @param array<string, mixed> $context
     */
    public static function securityEvent(string $event, string $severity = 'warning', array $context = []): void
    {
        $logMethod = match ($severity) {
            'critical', 'emergency' => 'critical',
            'error' => 'error',
            'warning' => 'warning',
            default => 'info',
        };

        Log::channel('security')->{$logMethod}("Security event: {$event}", array_merge([
            'event' => 'security_event',
            'security_event' => $event,
            'severity' => $severity,
            'component' => 'security_system',
            'requires_attention' => in_array($severity, ['critical', 'emergency', 'error']),
            'medical_context' => true,
        ], $context));
    }

    /**
     * Log performance metrics.
     *
     * @param array<string, mixed> $metrics
     */
    public static function performanceMetric(string $operation, float $duration, array $metrics = []): void
    {
        $level = match (true) {
            $duration > 5000 => 'critical', // >5 seconds
            $duration > 2000 => 'warning',  // >2 seconds
            $duration > 1000 => 'info',     // >1 second
            default => 'debug',
        };

        Log::channel('performance')->{$level}("Performance metric: {$operation}", array_merge([
            'event' => 'performance_metric',
            'operation' => $operation,
            'duration_ms' => round($duration, 2),
            'performance_level' => self::getPerformanceLevel($duration),
            'component' => 'performance_monitor',
            'needs_attention' => $duration > 2000,
        ], $metrics));
    }

    /**
     * Log audit events for compliance.
     *
     * @param array<string, mixed> $context
     */
    public static function auditEvent(string $action, string $resource, array $context = []): void
    {
        Log::channel('audit')->info("Audit: {$action} on {$resource}", array_merge([
            'event' => 'audit_event',
            'audit_action' => $action,
            'audit_resource' => $resource,
            'component' => 'audit_system',
            'compliance' => 'medical_practice',
            'retention_required' => true,
            'timestamp_utc' => now()->utc()->toISOString(),
        ], $context));
    }

    /**
     * Log validation errors with context.
     *
     * @param array<string, mixed> $context
     */
    public static function validationError(string $field, string $rule, mixed $value = null, array $context = []): void
    {
        Log::channel('contact_form')->warning("Validation error: {$field} failed {$rule}", array_merge([
            'event' => 'validation_error',
            'field' => $field,
            'validation_rule' => $rule,
            'value_type' => gettype($value),
            'component' => 'form_validation',
            'action' => 'validate_input',
            'outcome' => 'validation_failed',
            'patient_interaction' => true,
        ], $context));
    }

    /**
     * Log cache operations.
     *
     * @param array<string, mixed> $context
     */
    public static function cacheOperation(string $operation, string $key, bool $success, array $context = []): void
    {
        $level = $success ? 'debug' : 'warning';

        Log::channel('performance')->{$level}("Cache {$operation}: {$key}", array_merge([
            'event' => 'cache_operation',
            'cache_operation' => $operation,
            'cache_key' => self::hashCacheKey($key),
            'success' => $success,
            'component' => 'cache_system',
            'performance_impact' => !$success,
        ], $context));
    }

    /**
     * Log database operations with performance context.
     *
     * @param array<string, mixed> $context
     */
    public static function databaseOperation(string $operation, string $table, float $duration, array $context = []): void
    {
        $level = match (true) {
            $duration > 1000 => 'warning', // >1 second
            $duration > 500 => 'info',     // >500ms
            default => 'debug',
        };

        Log::channel('performance')->{$level}("Database {$operation} on {$table}", array_merge([
            'event' => 'database_operation',
            'db_operation' => $operation,
            'db_table' => $table,
            'duration_ms' => round($duration, 2),
            'component' => 'database_system',
            'performance_concern' => $duration > 500,
        ], $context));
    }

    /**
     * Log user actions for audit trail.
     *
     * @param array<string, mixed> $context
     */
    public static function userAction(string $action, array $context = []): void
    {
        Log::channel('audit')->info("User action: {$action}", array_merge([
            'event' => 'user_action',
            'user_action' => $action,
            'component' => 'user_system',
            'audit_trail' => true,
            'session_id' => self::getHashedSessionId(),
        ], $context));
    }

    /**
     * Log system health checks.
     *
     * @param array<string, mixed> $metrics
     */
    public static function healthCheck(string $component, bool $healthy, array $metrics = []): void
    {
        $level = $healthy ? 'info' : 'error';

        Log::channel('medical_structured')->{$level}("Health check: {$component}", array_merge([
            'event' => 'health_check',
            'health_component' => $component,
            'health_status' => $healthy ? 'healthy' : 'unhealthy',
            'component' => 'health_monitor',
            'system_critical' => !$healthy,
            'uptime_impact' => !$healthy,
        ], $metrics));
    }

    /**
     * Hash email addresses for privacy compliance.
     */
    private static function hashEmail(string $email): string
    {
        // In production, hash emails for privacy
        if (config('app.env') === 'production') {
            $appKey = config('app.key');
            $keyString = is_string($appKey) ? $appKey : '';
            return 'email_' . substr(hash('sha256', $email . $keyString), 0, 8);
        }

        // In development, show partial email for debugging
        $parts = explode('@', $email);
        if (count($parts) === 2) {
            $local = substr($parts[0], 0, 2) . '***';
            $domain = $parts[1];
            return $local . '@' . $domain;
        }

        return 'email_masked';
    }

    /**
     * Hash cache keys to prevent information leakage.
     */
    private static function hashCacheKey(string $key): string
    {
        // Only show prefix for debugging, hash the rest
        $prefix = substr($key, 0, 10);
        $hash = substr(hash('sha256', $key), 0, 8);
        
        return $prefix . '_' . $hash;
    }

    /**
     * Get performance level description.
     */
    private static function getPerformanceLevel(float $duration): string
    {
        return match (true) {
            $duration > 5000 => 'critical',
            $duration > 2000 => 'slow',
            $duration > 1000 => 'acceptable',
            $duration > 500 => 'good',
            default => 'excellent',
        };
    }

    /**
     * Get hashed session ID for correlation.
     */
    private static function getHashedSessionId(): ?string
    {
        if (!app()->bound('request')) {
            return null;
        }

        $request = app('request');
        if (!$request instanceof Request) {
            return null;
        }

        $sessionId = $request->session()->getId();
        if (!$sessionId) {
            return null;
        }

        return 'session_' . substr(hash('sha256', $sessionId), 0, 8);
    }
}