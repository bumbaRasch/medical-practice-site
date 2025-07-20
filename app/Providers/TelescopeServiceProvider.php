<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class TelescopeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Only register Telescope if the package is installed
        if (!class_exists('Laravel\Telescope\Telescope')) {
            return;
        }

        // Telescope::night();

        $this->hideSensitiveRequestDetails();

        $this->configureSampling();

        \Laravel\Telescope\Telescope::filter(function (mixed $entry): bool {
            // Only enable in local and staging environments
            if ($this->app->environment('local', 'staging')) {
                return true;
            }

            // In production, only capture exceptions and errors
            if (!$this->app->environment('production')) {
                return false;
            }
            
            // Check if entry has the required methods and call them safely
            if (is_object($entry)) {
                $isReportable = method_exists($entry, 'isReportableException') && 
                               (bool) call_user_func([$entry, 'isReportableException']);
                $isFailed = method_exists($entry, 'isFailedRequest') && 
                           (bool) call_user_func([$entry, 'isFailedRequest']);
                $hasTag = method_exists($entry, 'hasMonitoredTag') && 
                         (bool) call_user_func([$entry, 'hasMonitoredTag']);
                
                return $isReportable || $isFailed || $hasTag;
            }
            
            return false;
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     */
    protected function hideSensitiveRequestDetails(): void
    {
        if (!class_exists('Laravel\Telescope\Telescope')) {
            return;
        }
        
        if ($this->app->environment('local')) {
            return;
        }

        \Laravel\Telescope\Telescope::hideRequestParameters(['_token']);

        \Laravel\Telescope\Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Configure the Telescope sampling settings.
     */
    protected function configureSampling(): void
    {
        if (!class_exists('Laravel\Telescope\Telescope')) {
            return;
        }
        
        // Sample different percentages based on environment
        if ($this->app->environment('production')) {
            \Laravel\Telescope\Telescope::sample('exception', 100); // Capture all exceptions
            \Laravel\Telescope\Telescope::sample('request', 10);    // Sample 10% of requests
            \Laravel\Telescope\Telescope::sample('query', 25);      // Sample 25% of queries
            \Laravel\Telescope\Telescope::sample('mail', 100);      // Capture all emails
        } else {
            // In development, capture everything
            \Laravel\Telescope\Telescope::sample('exception', 100);
            \Laravel\Telescope\Telescope::sample('request', 100);
            \Laravel\Telescope\Telescope::sample('query', 100);
            \Laravel\Telescope\Telescope::sample('mail', 100);
        }
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewTelescope', function ($user = null) {
            // Allow access in local environment
            if ($this->app->environment('local')) {
                return true;
            }

            // In production, restrict access to admin users
            // Note: Implement your own admin check logic here
            return false;
            
            // Example admin check (uncomment and modify as needed):
            // return $user && $user->email === 'admin@example.com';
        });
    }
}