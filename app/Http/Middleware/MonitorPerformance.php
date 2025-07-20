<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Logging\MedicalLogger;
use Symfony\Component\HttpFoundation\Response;

/**
 * Performance Monitoring Middleware
 * 
 * Monitors request performance and logs structured metrics
 * for medical practice website optimization.
 */
class MonitorPerformance
{
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage(true);

        $response = $next($request);

        $endTime = microtime(true);
        $endMemory = memory_get_usage(true);

        $duration = round(($endTime - $startTime) * 1000, 2); // Convert to milliseconds
        $memoryUsage = round(($endMemory - $startMemory) / 1024 / 1024, 2); // Convert to MB
        $peakMemory = round(memory_get_peak_usage(true) / 1024 / 1024, 2);

        // Log performance metrics using structured logging
        MedicalLogger::performanceMetric(
            $this->getOperationName($request),
            $duration,
            [
                'memory_used_mb' => $memoryUsage,
                'memory_peak_mb' => $peakMemory,
                'response_status' => $response->getStatusCode(),
                'route_name' => $request->route()?->getName(),
                'request_method' => $request->method(),
                'request_path' => $request->path(),
                'is_ajax' => $request->ajax(),
                'user_agent_type' => $this->getUserAgentType($request),
                'response_size_kb' => $this->getResponseSize($response),
            ]
        );

        // Log slow requests with additional context
        if ($duration > 2000) { // >2 seconds
            MedicalLogger::performanceMetric(
                'slow_request_detected',
                $duration,
                [
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'memory_usage_mb' => $memoryUsage,
                    'status' => $response->getStatusCode(),
                    'route' => $request->route()?->getName(),
                    'query_count' => $this->getQueryCount(),
                    'slow_threshold_exceeded' => true,
                    'performance_issue' => 'requires_investigation',
                ]
            );
        }

        // Add performance headers in development
        if (app()->environment('local')) {
            $response->headers->set('X-Response-Time', $duration . 'ms');
            $response->headers->set('X-Memory-Usage', $memoryUsage . 'MB');
            $response->headers->set('X-Peak-Memory', $peakMemory . 'MB');
            $response->headers->set('X-Query-Count', (string) $this->getQueryCount());
        }

        // Log critical performance issues
        if ($duration > 5000) { // >5 seconds
            MedicalLogger::securityEvent(
                'critical_performance_degradation',
                'critical',
                [
                    'duration_ms' => $duration,
                    'memory_mb' => $memoryUsage,
                    'url' => $request->fullUrl(),
                    'impact' => 'user_experience_severely_degraded',
                    'action_required' => 'immediate_investigation',
                ]
            );
        }

        return $response;
    }

    /**
     * Get descriptive operation name for logging.
     */
    private function getOperationName(Request $request): string
    {
        $routeName = $request->route()?->getName();

        if ($routeName) {
            return "route_{$routeName}";
        }

        $path = $request->path();
        $method = strtolower($request->method());

        // Map common paths to operation names
        $pathMappings = [
            '' => 'homepage',
            '/' => 'homepage',
            'kontakt' => 'contact_page',
            'leistungen' => 'services_page',
            'team' => 'team_page',
            'faq' => 'faq_page',
            'form/request' => 'contact_form_submit',
            'api/health' => 'health_check',
            'telescope' => 'telescope_dashboard',
        ];

        $operation = $pathMappings[$path] ?? "unknown_path_{$path}";

        return "{$method}_{$operation}";
    }

    /**
     * Get user agent type for analytics.
     */
    private function getUserAgentType(Request $request): string
    {
        $userAgent = $request->userAgent() ?? '';

        if (str_contains($userAgent, 'Mobile')) {
            return 'mobile';
        }

        if (str_contains($userAgent, 'Tablet')) {
            return 'tablet';
        }

        if (str_contains($userAgent, 'Bot') || str_contains($userAgent, 'bot')) {
            return 'bot';
        }

        return 'desktop';
    }

    /**
     * Get response size in KB.
     */
    private function getResponseSize(Response $response): float
    {
        $content = $response->getContent();

        if (!$content) {
            return 0;
        }

        return round(strlen($content) / 1024, 2);
    }

    /**
     * Get database query count if available.
     */
    private function getQueryCount(): int
    {
        // Try to get query count from Laravel's query log
        if (config('database.log', false)) {
            return count(DB::getQueryLog());
        }

        // Fallback: estimate based on typical medical practice operations
        return 0;
    }
}
