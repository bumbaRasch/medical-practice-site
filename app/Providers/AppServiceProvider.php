<?php

namespace App\Providers;

use App\Contracts\ContactFormServiceInterface;
use App\Http\Services\ContactFormService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind contact form service interface to concrete implementation
        $this->app->bind(ContactFormServiceInterface::class, ContactFormService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerBladeDirectives();
    }

    /**
     * Register custom Blade directives for caching.
     */
    private function registerBladeDirectives(): void
    {
        // Cache directive for fragment caching
        Blade::directive('cache', function ($expression) {
            $args = explode(',', $expression, 2);
            $key = trim($args[0], " \"'");
            $ttl = isset($args[1]) ? trim($args[1]) : '3600'; // 1 hour default
            
            return "<?php if(Cache::has('$key')): echo Cache::get('$key'); else: ob_start(); ?>";
        });

        Blade::directive('endcache', function ($expression) {
            $args = explode(',', $expression, 2);
            $key = trim($args[0], " \"'");
            $ttl = isset($args[1]) ? trim($args[1]) : '3600'; // 1 hour default
            
            return "<?php \$content = ob_get_clean(); Cache::put('$key', \$content, $ttl); echo \$content; endif; ?>";
        });

        // Cache directive with locale support
        Blade::directive('cachelocale', function ($expression) {
            $args = explode(',', $expression, 2);
            $key = trim($args[0], " \"'");
            $ttl = isset($args[1]) ? trim($args[1]) : '3600'; // 1 hour default
            $localeKey = $key . '_' . app()->getLocale();
            
            return "<?php if(Cache::has('$localeKey')): echo Cache::get('$localeKey'); else: ob_start(); ?>";
        });

        Blade::directive('endcachelocale', function ($expression) {
            $args = explode(',', $expression, 2);
            $key = trim($args[0], " \"'");
            $ttl = isset($args[1]) ? trim($args[1]) : '3600'; // 1 hour default
            $localeKey = $key . '_' . app()->getLocale();
            
            return "<?php \$content = ob_get_clean(); Cache::put('$localeKey', \$content, $ttl); echo \$content; endif; ?>";
        });
    }
}
