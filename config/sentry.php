<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sentry DSN
    |--------------------------------------------------------------------------
    |
    | Your Sentry project's DSN. You can find this in your Sentry project
    | settings. This is used to send exceptions and errors to Sentry.
    |
    */

    'dsn' => env('SENTRY_LARAVEL_DSN', env('SENTRY_DSN')),

    /*
    |--------------------------------------------------------------------------
    | Release
    |--------------------------------------------------------------------------
    |
    | Many Sentry features can be tied to a release. Set this to track the
    | version of your application being deployed. This should be a string.
    |
    */

    'release' => env('SENTRY_RELEASE'),

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | The environment your application is running in. This helps filter
    | errors by environment in the Sentry dashboard.
    |
    */

    'environment' => env('SENTRY_ENVIRONMENT', env('APP_ENV', 'production')),

    /*
    |--------------------------------------------------------------------------
    | Server Name
    |--------------------------------------------------------------------------
    |
    | The server name to send with error reports. This helps identify which
    | server an error occurred on in distributed environments.
    |
    */

    'server_name' => env('SENTRY_SERVER_NAME', gethostname()),

    /*
    |--------------------------------------------------------------------------
    | Sample Rate
    |--------------------------------------------------------------------------
    |
    | The percentage of errors that should be sent to Sentry. This can help
    | reduce noise and costs. Set to 1.0 to send all errors.
    |
    */

    'sample_rate' => (float) env('SENTRY_SAMPLE_RATE', 1.0),

    /*
    |--------------------------------------------------------------------------
    | Traces Sample Rate
    |--------------------------------------------------------------------------
    |
    | The percentage of transactions that should be sent to Sentry for
    | performance monitoring. Set to 0.1 (10%) for moderate traffic.
    |
    */

    'traces_sample_rate' => (float) env('SENTRY_TRACES_SAMPLE_RATE', 0.1),

    /*
    |--------------------------------------------------------------------------
    | Profiles Sample Rate
    |--------------------------------------------------------------------------
    |
    | The percentage of transactions that should be profiled. Profiling gives
    | you detailed performance insights. Keep this low to avoid overhead.
    |
    */

    'profiles_sample_rate' => (float) env('SENTRY_PROFILES_SAMPLE_RATE', 0.1),

    /*
    |--------------------------------------------------------------------------
    | Before Send Callback
    |--------------------------------------------------------------------------
    |
    | Configure what data should be sent to Sentry. This callback is called
    | before each event is sent and allows you to modify or filter events.
    |
    */

    'before_send' => function (Sentry\Event $event): ?Sentry\Event {
        // Don't send events in testing environment
        if (app()->environment('testing')) {
            return null;
        }

        // Filter out common non-critical exceptions
        $exception = $event->getExceptions()[0] ?? null;
        if ($exception) {
            $exceptionClass = $exception->getType();
            
            // Skip validation exceptions (handled by form)
            if ($exceptionClass === 'Illuminate\Validation\ValidationException') {
                return null;
            }
            
            // Skip 404 errors (common and usually not actionable)
            if ($exceptionClass === 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException') {
                return null;
            }
            
            // Skip CSRF token mismatches (common bot behavior)
            if ($exceptionClass === 'Illuminate\Session\TokenMismatchException') {
                return null;
            }
        }

        return $event;
    },

    /*
    |--------------------------------------------------------------------------
    | Breadcrumbs
    |--------------------------------------------------------------------------
    |
    | Configure how breadcrumbs are collected to provide context for errors.
    | Breadcrumbs show the sequence of events leading up to an error.
    |
    */

    'breadcrumbs' => [
        // SQL queries - useful for debugging database issues
        'sql_queries' => env('SENTRY_BREADCRUMBS_SQL_QUERIES_ENABLED', true),
        
        // SQL query bindings - may contain sensitive data
        'sql_bindings' => env('SENTRY_BREADCRUMBS_SQL_BINDINGS_ENABLED', false),
        
        // Queue job information
        'queue_info' => env('SENTRY_BREADCRUMBS_QUEUE_INFO_ENABLED', true),
        
        // Cache operations
        'cache' => env('SENTRY_BREADCRUMBS_CACHE_ENABLED', false),
        
        // HTTP requests made by your application
        'http_client' => env('SENTRY_BREADCRUMBS_HTTP_CLIENT_ENABLED', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Send Default PII
    |--------------------------------------------------------------------------
    |
    | Whether to send personally identifiable information like IP addresses
    | and usernames. Disable this for GDPR compliance.
    |
    */

    'send_default_pii' => env('SENTRY_SEND_DEFAULT_PII', false),

    /*
    |--------------------------------------------------------------------------
    | Ignored Exceptions
    |--------------------------------------------------------------------------
    |
    | List of exception classes that should not be sent to Sentry. These are
    | typically handled gracefully by your application.
    |
    */

    'ignore_exceptions' => [
        Illuminate\Auth\AuthenticationException::class,
        Illuminate\Auth\Access\AuthorizationException::class,
        Illuminate\Database\Eloquent\ModelNotFoundException::class,
        Illuminate\Http\Exceptions\ThrottleRequestsException::class,
        Illuminate\Session\TokenMismatchException::class,
        Illuminate\Validation\ValidationException::class,
        Symfony\Component\HttpKernel\Exception\HttpException::class,
        Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tracing
    |--------------------------------------------------------------------------
    |
    | Configure performance monitoring settings. This helps track slow
    | database queries, HTTP requests, and other performance issues.
    |
    */

    'tracing' => [
        // Track database queries
        'sql_queries' => env('SENTRY_TRACING_SQL_QUERIES_ENABLED', true),
        
        // Track queue jobs
        'queue_jobs' => env('SENTRY_TRACING_QUEUE_JOBS_ENABLED', true),
        
        // Track HTTP requests to external services
        'http_client' => env('SENTRY_TRACING_HTTP_CLIENT_ENABLED', true),
        
        // Track cache operations
        'cache' => env('SENTRY_TRACING_CACHE_ENABLED', false),
        
        // Queries slower than this (in milliseconds) will be highlighted
        'sql_origin' => env('SENTRY_TRACING_SQL_ORIGIN_ENABLED', true),
        
        // Missing routes (404s) tracking
        'missing_routes' => env('SENTRY_TRACING_MISSING_ROUTES_ENABLED', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Context
    |--------------------------------------------------------------------------
    |
    | Additional context to include with every error report. This helps
    | provide more information for debugging.
    |
    */

    'context' => [
        // Include user context (if authenticated)
        'user' => true,
        
        // Include request context (URL, method, etc.)
        'request' => true,
        
        // Include extra context
        'extra' => [
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Integrations
    |--------------------------------------------------------------------------
    |
    | Configure Sentry integrations. These provide additional functionality
    | and context for error reporting. Only configure when Sentry is installed.
    |
    */

    'integrations' => [
        // Integrations will be auto-configured when Sentry package is installed
        // This prevents configuration errors when package is not yet installed
    ],
];