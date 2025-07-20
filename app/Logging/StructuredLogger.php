<?php

namespace App\Logging;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Monolog\Formatter\JsonFormatter;
use Monolog\LogRecord;

/**
 * Structured Logger for Medical Practice Website
 * 
 * Provides JSON-formatted logging with context-aware metadata
 * following medical practice security and privacy requirements.
 */
class StructuredLogger
{
    /**
     * Create a custom JSON formatter with medical practice context.
     */
    public static function createJsonFormatter(): JsonFormatter
    {
        return new class extends JsonFormatter {
            public function format(LogRecord $record): string
            {
                // Build structured log entry
                $logEntry = [
                    // Standard fields
                    'timestamp' => $record->datetime->format('c'),
                    'level' => strtolower($record->level->name),
                    'level_name' => $record->level->name,
                    'message' => $record->message,
                    'channel' => $record->channel,
                    
                    // Application context
                    'application' => [
                        'name' => config('app.name'),
                        'environment' => config('app.env'),
                        'version' => '1.0.0',
                        'locale' => app()->getLocale(),
                    ],
                    
                    // Request context (if available)
                    'request' => self::getRequestContext(),
                    
                    // User context (if authenticated)
                    'user' => self::getUserContext(),
                    
                    // System context
                    'system' => self::getSystemContext(),
                    
                    // Medical practice context
                    'medical_context' => self::getMedicalContext($record),
                    
                    // Original context data (filtered for privacy)
                    'context' => self::filterSensitiveData($record->context),
                    
                    // Extra data (filtered for privacy)
                    'extra' => self::filterSensitiveData($record->extra),
                ];

                // Add trace ID for request correlation
                if ($traceId = self::getTraceId()) {
                    $logEntry['trace_id'] = $traceId;
                }

                // Remove null values to keep logs clean
                $logEntry = array_filter($logEntry, function ($value) {
                    return $value !== null && $value !== [] && $value !== '';
                });

                return json_encode($logEntry, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            }

            /**
             * Get request context information.
             *
             * @return array<string, mixed>|null
             */
            private static function getRequestContext(): ?array
            {
                if (!app()->bound('request')) {
                    return null;
                }

                $request = app('request');
                if (!$request instanceof Request) {
                    return null;
                }

                return [
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'path' => $request->path(),
                    'route' => $request->route()?->getName() ?? null,
                    'ip' => self::getClientIp($request),
                    'user_agent' => $request->userAgent(),
                    'referer' => $request->header('referer'),
                    'accept_language' => $request->header('accept-language'),
                    'is_secure' => $request->isSecure(),
                    'is_ajax' => $request->ajax(),
                    'session_id' => self::getHashedSessionId($request),
                ];
            }

            /**
             * Get user context information.
             * Note: Medical practice website has no authentication system
             *
             * @return null
             */
            private static function getUserContext(): null
            {
                // No authentication system in medical practice website
                return null;
            }

            /**
             * Get system context information.
             *
             * @return array<string, mixed>
             */
            private static function getSystemContext(): array
            {
                return [
                    'hostname' => gethostname(),
                    'process_id' => getmypid(),
                    'memory_usage' => [
                        'current' => round(memory_get_usage(true) / 1024 / 1024, 2) . 'MB',
                        'peak' => round(memory_get_peak_usage(true) / 1024 / 1024, 2) . 'MB',
                    ],
                    'php_version' => PHP_VERSION,
                    'laravel_version' => app()->version(),
                ];
            }

            /**
             * Get medical practice specific context.
             *
             * @return array<string, mixed>
             */
            private static function getMedicalContext(LogRecord $record): array
            {
                $context = [
                    'practice_type' => 'general_medicine',
                    'patient_privacy' => 'protected',
                    'gdpr_compliant' => true,
                ];

                // Add context based on log channel/message
                if (str_contains($record->channel, 'contact')) {
                    $context['component'] = 'contact_form';
                    $context['patient_interaction'] = true;
                }

                if (str_contains($record->message, 'Contact form')) {
                    $context['component'] = 'contact_form';
                    $context['patient_data'] = 'processed';
                }

                if (str_contains($record->message, 'email')) {
                    $context['component'] = 'email_system';
                    $context['communication'] = 'patient_notification';
                }

                if (str_contains($record->message, 'cache')) {
                    $context['component'] = 'cache_system';
                    $context['performance'] = true;
                }

                return $context;
            }

            /**
             * Filter sensitive data from log context.
             *
             * @param array<string, mixed> $data
             * @return array<string, mixed>
             */
            private static function filterSensitiveData(array $data): array
            {
                $sensitiveKeys = [
                    // Patient information
                    'password', 'password_confirmation', '_token', 'csrf_token',
                    'email', 'phone', 'full_name', 'message', // Patient contact info
                    
                    // System sensitive data
                    'authorization', 'x-api-key', 'cookie', 'session',
                    'database_url', 'redis_url', 'sentry_dsn',
                    
                    // Medical specific
                    'patient_id', 'medical_record', 'diagnosis', 'treatment',
                ];

                return self::recursiveFilter($data, $sensitiveKeys);
            }

            /**
             * Recursively filter sensitive data.
             *
             * @param array<string, mixed> $data
             * @param array<string> $sensitiveKeys
             * @return array<string, mixed>
             */
            private static function recursiveFilter(array $data, array $sensitiveKeys): array
            {
                $filtered = [];

                foreach ($data as $key => $value) {
                    $lowerKey = strtolower($key);
                    
                    // Check if key is sensitive
                    $isSensitive = false;
                    foreach ($sensitiveKeys as $sensitiveKey) {
                        if (str_contains($lowerKey, strtolower($sensitiveKey))) {
                            $isSensitive = true;
                            break;
                        }
                    }

                    if ($isSensitive) {
                        $filtered[$key] = '[FILTERED]';
                    } elseif (is_array($value)) {
                        /** @var array<string, mixed> $value */
                        $filtered[$key] = self::recursiveFilter($value, $sensitiveKeys);
                    } else {
                        $filtered[$key] = $value;
                    }
                }

                return $filtered;
            }

            /**
             * Get client IP address with privacy considerations.
             */
            private static function getClientIp(Request $request): string
            {
                $ip = $request->ip();
                
                if ($ip === null) {
                    return 'unknown';
                }
                
                // Hash IP for privacy compliance (GDPR)
                if (config('app.env') === 'production') {
                    $appKey = config('app.key');
                    $keyString = is_string($appKey) ? $appKey : '';
                    return 'hashed_' . substr(hash('sha256', $ip . $keyString), 0, 8);
                }

                return $ip;
            }

            /**
             * Get hashed session ID for correlation without exposing actual session.
             */
            private static function getHashedSessionId(Request $request): ?string
            {
                $sessionId = $request->session()->getId();
                
                if (!$sessionId) {
                    return null;
                }

                return 'session_' . substr(hash('sha256', $sessionId), 0, 8);
            }

            /**
             * Get or generate trace ID for request correlation.
             */
            private static function getTraceId(): ?string
            {
                // Check if trace ID already exists in request
                if (app()->bound('request')) {
                    $request = app('request');
                    if ($request instanceof Request) {
                        // Check for existing trace ID in headers
                        if ($traceId = $request->header('X-Trace-ID')) {
                            return $traceId;
                        }

                        // Generate new trace ID for this request
                        $traceId = 'trace_' . Str::random(16);
                        $request->headers->set('X-Trace-ID', $traceId);
                        
                        return $traceId;
                    }
                }

                return null;
            }
        };
    }
}