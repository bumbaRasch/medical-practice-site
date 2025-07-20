<?php

namespace App\Http\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Service for dynamically loading slideshow images from the leistungen directory
 * 
 * Scans the public/images/leistungen directory and creates appropriate metadata
 * for each image including localized titles and descriptions.
 */
class SlideshowImageService
{
    private const IMAGE_DIRECTORY = 'images/leistungen';
    private const SUPPORTED_EXTENSIONS = ['webp', 'jpg', 'jpeg', 'png'];

    /**
     * Get all slideshow images with metadata
     * 
     * @return Collection<int, array{src: string, alt: string, title: string, description: string, key: string}>
     */
    public function getAllImages(): Collection
    {
        $publicPath = public_path(self::IMAGE_DIRECTORY);
        
        if (!File::exists($publicPath)) {
            return collect();
        }

        $files = File::files($publicPath);
        
        return collect($files)
            ->filter(fn($file) => in_array(strtolower($file->getExtension()), self::SUPPORTED_EXTENSIONS))
            ->map(fn($file) => $this->createImageMetadata($file->getFilename()))
            ->sortBy('title')
            ->values();
    }

    /**
     * Create metadata for a single image
     * 
     * @param string $filename
     * @return array{src: string, alt: string, title: string, description: string, key: string}
     */
    private function createImageMetadata(string $filename): array
    {
        $key = $this->generateImageKey($filename);
        
        return [
            'src' => '/' . self::IMAGE_DIRECTORY . '/' . $filename,
            'alt' => $this->getLocalizedText($key, 'title'),
            'title' => $this->getLocalizedText($key, 'title'),
            'description' => $this->getLocalizedText($key, 'description'),
            'key' => $key
        ];
    }

    /**
     * Generate a unique key for an image based on its filename
     * 
     * @param string $filename
     * @return string
     */
    private function generateImageKey(string $filename): string
    {
        // Remove extension and normalize filename
        $name = pathinfo($filename, PATHINFO_FILENAME);
        
        // Convert to snake_case key
        return Str::snake(Str::lower($name));
    }

    /**
     * Get localized text for an image
     * 
     * @param string $key
     * @param string $type ('title' or 'description')
     * @return string
     */
    private function getLocalizedText(string $key, string $type): string
    {
        $translationKey = "messages.services.slideshow_photos.{$key}.{$type}";
        $translated = __($translationKey);
        
        // If translation doesn't exist, generate a fallback based on filename
        if ($translated === $translationKey) {
            return $this->generateFallbackText($key, $type);
        }
        
        return $translated;
    }

    /**
     * Generate fallback text when translation is missing
     * 
     * @param string $key
     * @param string $type
     * @return string
     */
    private function generateFallbackText(string $key, string $type): string
    {
        // Convert snake_case key back to readable format
        $readable = Str::title(str_replace('_', ' ', $key));
        
        if ($type === 'title') {
            return $readable;
        }
        
        // Generate description based on the image key
        $descriptions = [
            'medical_consultation' => __('messages.services.slideshow_photos.fallback.consultation_desc', [], 'Professionelle medizinische Beratung'),
            'examination_room' => __('messages.services.slideshow_photos.fallback.examination_desc', [], 'Moderne Untersuchungsräume für Ihre Gesundheit'),
            'reception' => __('messages.services.slideshow_photos.fallback.reception_desc', [], 'Freundlicher Empfang und Service'),
            'waiting_room' => __('messages.services.slideshow_photos.fallback.waiting_desc', [], 'Komfortable Wartebereiche'),
            'laboratory' => __('messages.services.slideshow_photos.fallback.laboratory_desc', [], 'Moderne Labordiagnostik'),
            'vaccine' => __('messages.services.slideshow_photos.fallback.vaccine_desc', [], 'Präventionsmedizin und Impfungen'),
        ];
        
        // Try to match key patterns to descriptions
        foreach ($descriptions as $pattern => $description) {
            if (Str::contains($key, $pattern)) {
                return $description;
            }
        }
        
        return __('messages.services.slideshow_photos.fallback.default_desc', [], 'Moderne medizinische Versorgung in angenehmer Atmosphäre');
    }
}