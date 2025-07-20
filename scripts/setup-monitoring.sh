#!/bin/bash

# Medical Practice Monitoring Setup Script
# This script installs and configures monitoring tools for the Laravel application

set -e

echo "🔧 Setting up Application Monitoring..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if we're in the correct directory
if [ ! -f "artisan" ]; then
    print_error "This script must be run from the Laravel project root directory"
    exit 1
fi

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    print_error "Composer is not installed. Please install Composer first."
    exit 1
fi

print_status "Installing monitoring packages..."

# Install Telescope
composer require --dev laravel/telescope

# Install Sentry (optional - will be installed when DSN is configured)
if [ -n "${SENTRY_LARAVEL_DSN:-}" ]; then
    print_status "Installing Sentry (DSN configured)..."
    composer require sentry/sentry-laravel
else
    print_warning "Sentry DSN not configured - skipping Sentry installation"
    print_warning "Run 'composer require sentry/sentry-laravel' when ready to set up error monitoring"
fi

print_status "Publishing Telescope configuration and assets..."

# Publish Telescope service provider and assets
php artisan telescope:install

print_status "Running database migrations for Telescope..."

# Run Telescope migrations
php artisan migrate

print_status "Configuring Sentry..."

# Publish Sentry configuration if package is installed
if php -m | grep -q sentry || composer show sentry/sentry-laravel > /dev/null 2>&1; then
    print_status "Publishing Sentry configuration..."
    php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider" --tag=sentry-config --force
else
    print_warning "Sentry package not installed - configuration already provided"
    print_warning "Install with: composer require sentry/sentry-laravel"
fi

print_status "Configuring application monitoring..."

# Create monitoring command for artisan
cat > app/Console/Commands/MonitoringStatusCommand.php << 'EOF'
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Laravel\Telescope\Telescope;

class MonitoringStatusCommand extends Command
{
    protected $signature = 'monitoring:status';
    protected $description = 'Check monitoring system status';

    public function handle(): int
    {
        $this->info('🔍 Medical Practice Monitoring Status');
        $this->line('');

        // Check Telescope
        $this->checkTelescope();
        
        // Check Sentry
        $this->checkSentry();
        
        // Check Database
        $this->checkDatabase();
        
        // Check Cache
        $this->checkCache();

        $this->line('');
        $this->info('✅ Monitoring status check complete');
        
        return Command::SUCCESS;
    }

    private function checkTelescope(): void
    {
        $this->line('📡 <fg=blue>Telescope Status:</fg=blue>');
        
        if (config('telescope.enabled')) {
            $this->line('  ✅ Telescope is enabled');
            
            // Check if Telescope tables exist
            try {
                $count = DB::table('telescope_entries')->count();
                $this->line("  📊 Total entries: {$count}");
            } catch (\Exception $e) {
                $this->line('  ⚠️  Telescope database tables not found');
            }
        } else {
            $this->line('  ❌ Telescope is disabled');
        }
    }

    private function checkSentry(): void
    {
        $this->line('🚨 <fg=red>Sentry Status:</fg=red>');
        
        $dsn = config('sentry.dsn');
        if ($dsn) {
            $this->line('  ✅ Sentry DSN configured');
            $this->line("  🔗 Environment: " . config('sentry.environment'));
        } else {
            $this->line('  ⚠️  Sentry DSN not configured');
        }
    }

    private function checkDatabase(): void
    {
        $this->line('🗄️  <fg=green>Database Status:</fg=green>');
        
        try {
            DB::connection()->getPdo();
            $this->line('  ✅ Database connection successful');
            
            // Check contact form tables
            $formRequests = DB::table('form_requests')->count();
            $this->line("  📝 Form requests: {$formRequests}");
            
            $contactReasons = DB::table('contact_reasons')->count();
            $this->line("  📋 Contact reasons: {$contactReasons}");
            
        } catch (\Exception $e) {
            $this->line('  ❌ Database connection failed');
        }
    }

    private function checkCache(): void
    {
        $this->line('💾 <fg=yellow>Cache Status:</fg=yellow>');
        
        try {
            cache()->put('monitoring_test', 'ok', 60);
            $value = cache()->get('monitoring_test');
            
            if ($value === 'ok') {
                $this->line('  ✅ Cache is working');
            } else {
                $this->line('  ❌ Cache test failed');
            }
            
            cache()->forget('monitoring_test');
        } catch (\Exception $e) {
            $this->line('  ❌ Cache connection failed');
        }
    }
}
EOF

print_status "Creating monitoring middleware..."

# Create performance monitoring middleware
cat > app/Http/Middleware/MonitorPerformance.php << 'EOF'
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

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

        // Log slow requests (>2 seconds)
        if ($duration > 2000) {
            Log::warning('Slow request detected', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'duration_ms' => $duration,
                'memory_mb' => $memoryUsage,
                'status' => $response->getStatusCode(),
            ]);
        }

        // Add performance headers in development
        if (app()->environment('local')) {
            $response->headers->set('X-Response-Time', $duration . 'ms');
            $response->headers->set('X-Memory-Usage', $memoryUsage . 'MB');
        }

        return $response;
    }
}
EOF

print_status "Creating health check endpoint..."

# Create health check controller
cat > app/Http/Controllers/HealthCheckController.php << 'EOF'
<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HealthCheckController extends Controller
{
    /**
     * Perform application health check.
     */
    public function __invoke(): JsonResponse
    {
        $status = 'healthy';
        $checks = [];
        $timestamp = now()->toISOString();

        // Database check
        try {
            DB::connection()->getPdo();
            $checks['database'] = [
                'status' => 'healthy',
                'message' => 'Database connection successful'
            ];
        } catch (\Exception $e) {
            $status = 'unhealthy';
            $checks['database'] = [
                'status' => 'unhealthy',
                'message' => 'Database connection failed: ' . $e->getMessage()
            ];
        }

        // Cache check
        try {
            $testKey = 'health_check_' . time();
            Cache::put($testKey, 'test', 60);
            $value = Cache::get($testKey);
            Cache::forget($testKey);

            if ($value === 'test') {
                $checks['cache'] = [
                    'status' => 'healthy',
                    'message' => 'Cache is working'
                ];
            } else {
                $status = 'unhealthy';
                $checks['cache'] = [
                    'status' => 'unhealthy',
                    'message' => 'Cache test failed'
                ];
            }
        } catch (\Exception $e) {
            $status = 'unhealthy';
            $checks['cache'] = [
                'status' => 'unhealthy',
                'message' => 'Cache error: ' . $e->getMessage()
            ];
        }

        // Disk space check
        $diskFree = disk_free_space('/');
        $diskTotal = disk_total_space('/');
        $diskUsagePercent = round((($diskTotal - $diskFree) / $diskTotal) * 100, 2);

        if ($diskUsagePercent > 90) {
            $status = 'unhealthy';
            $checks['disk'] = [
                'status' => 'unhealthy',
                'message' => "Disk usage is {$diskUsagePercent}% (critical)"
            ];
        } elseif ($diskUsagePercent > 80) {
            $checks['disk'] = [
                'status' => 'warning',
                'message' => "Disk usage is {$diskUsagePercent}% (warning)"
            ];
        } else {
            $checks['disk'] = [
                'status' => 'healthy',
                'message' => "Disk usage is {$diskUsagePercent}%"
            ];
        }

        return response()->json([
            'status' => $status,
            'timestamp' => $timestamp,
            'application' => [
                'name' => config('app.name'),
                'version' => '1.0.0',
                'environment' => config('app.env'),
            ],
            'checks' => $checks,
        ], $status === 'healthy' ? 200 : 503);
    }
}
EOF

print_status "Adding health check route..."

# Add health check route to api routes
if ! grep -q "health" routes/api.php; then
    echo "" >> routes/api.php
    echo "// Health check endpoint" >> routes/api.php
    echo "Route::get('/health', App\\Http\\Controllers\\HealthCheckController::class);" >> routes/api.php
fi

print_status "Creating monitoring documentation..."

# Create monitoring documentation
cat > docs/MONITORING.md << 'EOF'
# 🔍 Application Monitoring Guide

## Overview

This medical practice website includes comprehensive monitoring through Laravel Telescope and Sentry integration.

## Monitoring Tools

### 🔭 Laravel Telescope

**Purpose**: Development and staging environment monitoring
**Access**: `/telescope` (local environment only)
**Features**:
- Request/Response monitoring
- Database query analysis
- Mail tracking
- Cache operations
- Exception tracking
- Performance metrics

### 🚨 Sentry Error Tracking

**Purpose**: Production error monitoring and alerting
**Features**:
- Real-time error tracking
- Performance monitoring
- Release tracking
- Custom alerts

## Health Check Endpoint

**URL**: `/api/health`
**Purpose**: System health monitoring for uptime services

**Response Example**:
```json
{
  "status": "healthy",
  "timestamp": "2025-07-19T10:30:00.000Z",
  "application": {
    "name": "Medical Practice",
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
      "status": "healthy",
      "message": "Disk usage is 45%"
    }
  }
}
```

## Monitoring Commands

### Check Monitoring Status
```bash
php artisan monitoring:status
```

### Clear Telescope Data
```bash
php artisan telescope:clear
```

### Test Sentry Integration
```bash
php artisan sentry:test
```

## Key Metrics to Monitor

### Contact Form Metrics
- Submission success rate
- Validation error frequency
- Email delivery success
- Response times

### System Performance
- Database query performance
- Cache hit rates
- Memory usage
- Response times

### Error Tracking
- Application exceptions
- Failed form submissions
- Email delivery failures
- 404/500 errors

## Alerts Configuration

### Critical Alerts
- Application errors (Sentry)
- Database connection failures
- Email delivery failures
- High response times (>5s)

### Warning Alerts  
- Slow database queries (>100ms)
- High disk usage (>80%)
- Cache misses
- Form validation errors

## Production Monitoring Checklist

- [ ] Sentry DSN configured
- [ ] Health check endpoint accessible
- [ ] Log monitoring configured
- [ ] Uptime monitoring active
- [ ] Performance baselines established
- [ ] Alert thresholds configured

## Troubleshooting

### Common Issues

**Telescope not accessible**:
- Check `TELESCOPE_ENABLED` environment variable
- Verify database migrations are run
- Check authentication gate in TelescopeServiceProvider

**Sentry not receiving errors**:
- Verify `SENTRY_LARAVEL_DSN` is set
- Check sample rates in configuration
- Verify network connectivity

**Health check failing**:
- Check database connectivity
- Verify cache configuration
- Check disk space availability

## Security Considerations

- Telescope is disabled in production by default
- Sensitive data is filtered from Sentry reports
- Health check includes minimal system information
- Performance headers only shown in development
EOF

print_status "Setting proper file permissions..."

# Make scripts executable
chmod +x scripts/setup-monitoring.sh

print_status "Clearing application caches..."

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

print_status "✅ Monitoring setup complete!"

echo ""
print_status "Next steps:"
echo "1. Configure Sentry DSN in your .env file"
echo "2. Run 'php artisan monitoring:status' to check system status"
echo "3. Access Telescope at /telescope (local environment)"
echo "4. Set up external uptime monitoring for /api/health"
echo "5. Configure alert thresholds based on your requirements"

print_warning "Remember to:"
echo "- Keep Telescope disabled in production"
echo "- Monitor Sentry quotas and billing"
echo "- Regularly review performance metrics"
echo "- Test alert notifications"