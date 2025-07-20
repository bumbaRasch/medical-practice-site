<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

/**
 * Generate Build Timestamp Command
 * 
 * Creates a build timestamp file for accurate sitemap.xml last-modified dates.
 * Should be run during deployment or build process.
 */
class GenerateBuildTimestamp extends Command
{
    protected $signature = 'sitemap:build-timestamp {--force : Force overwrite existing timestamp}';
    
    protected $description = 'Generate build timestamp for sitemap.xml last-modified dates';

    public function handle(): int
    {
        $timestampFile = base_path('.build-timestamp');
        
        // Check if file exists and not forcing
        if (file_exists($timestampFile) && !$this->option('force')) {
            $this->warn('Build timestamp already exists. Use --force to overwrite.');
            $this->info('Current timestamp: ' . $this->getExistingTimestamp());
            return Command::SUCCESS;
        }
        
        // Generate current timestamp
        $timestamp = Carbon::now()->timestamp;
        
        // Write to file
        if (file_put_contents($timestampFile, $timestamp) === false) {
            $this->error('Failed to write build timestamp file.');
            return Command::FAILURE;
        }
        
        // Success message
        $formattedDate = Carbon::createFromTimestamp($timestamp)->format('Y-m-d H:i:s T');
        $this->info('✅ Build timestamp generated successfully!');
        $this->line("📅 Timestamp: {$formattedDate}");
        $this->line("📁 File: {$timestampFile}");
        
        // Show sitemap impact
        $this->newLine();
        $this->info('🔍 This timestamp will be used in sitemap.xml for last-modified dates.');
        $this->line('🌐 Sitemap URL: ' . route('sitemap'));
        
        return Command::SUCCESS;
    }
    
    /**
     * Get existing timestamp information.
     */
    private function getExistingTimestamp(): string
    {
        $timestampFile = base_path('.build-timestamp');
        
        if (!file_exists($timestampFile)) {
            return 'No timestamp file found';
        }
        
        $timestamp = (int) file_get_contents($timestampFile);
        return Carbon::createFromTimestamp($timestamp)->format('Y-m-d H:i:s T');
    }
}