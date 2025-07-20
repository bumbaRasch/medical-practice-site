<?php

namespace App\Console\Commands;

use App\Services\CacheService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Spatie\ResponseCache\Facades\ResponseCache;

/**
 * Artisan command to warm up various caches for better performance.
 */
class WarmCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'cache:warm 
                            {--force : Force cache refresh even if cache exists}
                            {--response : Only warm response cache}
                            {--content : Only warm content cache}';

    /**
     * The console command description.
     */
    protected $description = 'Warm up application caches for better performance';

    /**
     * Execute the console command.
     */
    public function handle(CacheService $cacheService): int
    {
        $this->info('🚀 Starting cache warming process...');

        $force = $this->option('force');
        $responseOnly = $this->option('response');
        $contentOnly = $this->option('content');

        try {
            // Clear existing cache if force flag is used
            if ($force) {
                $this->warn('🧹 Force flag detected, clearing existing cache...');
                $this->call('cache:clear');
                $this->call('responsecache:clear');
            }

            // Warm content cache (unless response-only flag is used)
            if (!$responseOnly) {
                $this->warmContentCache($cacheService);
            }

            // Warm response cache (unless content-only flag is used)
            if (!$contentOnly) {
                $this->warmResponseCache();
            }

            // Warm Laravel's built-in caches
            if (!$responseOnly && !$contentOnly) {
                $this->warmLaravelCaches();
            }

            $this->newLine();
            $this->info('✅ Cache warming completed successfully!');
            
            // Show cache statistics
            $this->showCacheStats($cacheService);
            
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Cache warming failed: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Warm content cache using CacheService.
     */
    private function warmContentCache(CacheService $cacheService): void
    {
        $this->info('📦 Warming content cache...');

        $bar = $this->output->createProgressBar(4);
        $bar->setFormat('debug');

        // Warm practice services
        $bar->setMessage('Practice services');
        $cacheService->getPracticeServices();
        $bar->advance();

        // Warm practice team
        $bar->setMessage('Practice team');
        $cacheService->getPracticeTeam();
        $bar->advance();

        // Define locales for reuse
        $locales = ['de', 'en'];
        
        // Warm practice FAQ content
        $bar->setMessage('Practice FAQ');
        foreach ($locales as $locale) {
            $cacheService->getFAQLocalized($locale);
            $cacheService->getPracticeTeamLocalized($locale);
        }
        $bar->advance();

        // Warm localized content
        $bar->setMessage('Localized content');
        foreach ($locales as $locale) {
            $cacheService->getOpeningHours($locale);
            $cacheService->getNavigationItems($locale);
        }
        $bar->advance();

        $bar->finish();
        $this->newLine();
        $this->line('  📦 Content cache warmed');
    }

    /**
     * Warm response cache by making HTTP requests to key pages.
     */
    private function warmResponseCache(): void
    {
        $this->info('🌐 Warming response cache...');

        $baseUrl = config('app.url');
        $locales = ['de', 'en'];
        
        // Define critical pages to warm
        $pages = [
            '/' => 'Homepage',
            '/services' => 'Services',
            '/team' => 'Team',
            '/events' => 'Events',
            '/contact' => 'Contact',
        ];

        $totalRequests = count($pages) * count($locales);
        $bar = $this->output->createProgressBar($totalRequests);
        $bar->setFormat('debug');

        foreach ($locales as $locale) {
            foreach ($pages as $path => $name) {
                $baseUrlString = is_string($baseUrl) ? $baseUrl : 'http://localhost';
                $url = $baseUrlString . $path . '?lang=' . $locale;
                $bar->setMessage("$name ($locale)");
                
                try {
                    // Make HTTP request to warm cache
                    $context = stream_context_create([
                        'http' => [
                            'timeout' => 10,
                            'method' => 'GET',
                            'header' => [
                                'User-Agent: Laravel-CacheWarmer/1.0',
                                'Accept: text/html,application/xhtml+xml',
                            ],
                        ],
                    ]);
                    
                    @file_get_contents($url, false, $context);
                } catch (\Exception $e) {
                    // Log but don't fail - development server might not be running
                    $this->warn("Failed to warm: $url");
                }
                
                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine();
        $this->line('  🌐 Response cache warmed');
    }

    /**
     * Warm Laravel's built-in caches.
     */
    private function warmLaravelCaches(): void
    {
        $this->info('⚡ Warming Laravel caches...');

        $commands = [
            'config:cache' => 'Configuration cache',
            'route:cache' => 'Route cache', 
            'view:cache' => 'View cache',
        ];

        foreach ($commands as $command => $description) {
            $this->line("  - $description");
            Artisan::call($command);
        }

        $this->line('  ⚡ Laravel caches warmed');
    }

    /**
     * Show cache statistics.
     */
    private function showCacheStats(CacheService $cacheService): void
    {
        $this->info('📊 Cache Statistics:');
        
        $stats = $cacheService->getCacheStats();
        $table = [];
        
        foreach ($stats as $name => $cached) {
            $table[] = [
                'Cache Type' => ucwords(str_replace('_', ' ', $name)),
                'Status' => $cached ? '✅ Cached' : '❌ Not Cached',
            ];
        }
        
        $this->table(['Cache Type', 'Status'], $table);
        
        // Show some helpful tips
        $this->newLine();
        $this->info('💡 Performance Tips:');
        $this->line('  • Run this command after deployments: php artisan cache:warm --force');
        $this->line('  • Monitor cache hit rates in production');
        $this->line('  • Clear cache when content changes: php artisan responsecache:clear');
        $this->line('  • For development, use: php artisan cache:warm --content');
    }
}