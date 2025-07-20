{{-- 
Medical Practice Services Slideshow Component
A modern, accessible slideshow showcasing the medical practice environment
--}}

<section class="py-16 bg-gradient-to-br from-medical-light-blue to-gentle-mint relative overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute inset-0 opacity-5">
        <svg class="absolute top-10 left-10 w-24 h-24 text-medical-blue animate-pulse" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
        </svg>
        <svg class="absolute bottom-10 right-10 w-20 h-20 text-warm-green animate-pulse delay-2000" fill="currentColor" viewBox="0 0 24 24">
            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center px-4 py-2 bg-white bg-opacity-90 rounded-full text-sm font-medium text-trust-blue mb-6 shadow-gentle">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ __('messages.services.slideshow_badge') ?? 'Unsere Praxis' }}
            </div>
            
            <h2 class="text-3xl md:text-4xl font-bold text-warm-gray-900 mb-4">
                {{ __('messages.services.slideshow_title') ?? 'Einblick in unsere Praxis' }}
            </h2>
            <p class="text-lg text-warm-gray-600 max-w-2xl mx-auto">
                {{ __('messages.services.slideshow_subtitle') ?? 'Erleben Sie die warme und professionelle Atmosphäre unserer modernen Hausarztpraxis' }}
            </p>
        </div>

        <!-- Slideshow Container -->
        <div class="relative">
            <div class="medical-slideshow bg-white bg-opacity-90 backdrop-blur-sm rounded-3xl shadow-warm overflow-hidden"
                 role="region" 
                 aria-label="Praxis Bildergalerie"
                 data-auto-play="true"
                 data-interval="5000">
                
                <!-- Slideshow Images -->
                <div class="slideshow-container relative h-96 md:h-[500px] lg:h-[600px] overflow-hidden">
                    @php
                        $slideshowService = app(\App\Http\Services\SlideshowImageService::class);
                        $images = $slideshowService->getAllImages()->toArray();
                        
                        // Fallback to hardcoded images if service fails or no images found
                        if (empty($images)) {
                            $images = [
                                [
                                    'src' => '/images/leistungen/Medical Examination Room in Daylight.webp',
                                    'alt' => __('messages.services.slideshow_photos.examination_room.title'),
                                    'title' => __('messages.services.slideshow_photos.examination_room.title'),
                                    'description' => __('messages.services.slideshow_photos.examination_room.description')
                                ],
                                [
                                    'src' => '/images/leistungen/Modern Medical Office Reception.webp', 
                                    'alt' => __('messages.services.slideshow_photos.reception.title'),
                                    'title' => __('messages.services.slideshow_photos.reception.title'),
                                    'description' => __('messages.services.slideshow_photos.reception.description')
                                ],
                                [
                                    'src' => '/images/leistungen/Modern Waiting Room with Natural Light.webp',
                                    'alt' => __('messages.services.slideshow_photos.waiting_room.title'), 
                                    'title' => __('messages.services.slideshow_photos.waiting_room.title'),
                                    'description' => __('messages.services.slideshow_photos.waiting_room.description')
                                ]
                            ];
                        }
                    @endphp

                    @foreach($images as $index => $image)
                    <div class="slide {{ $index === 0 ? 'active' : '' }} absolute inset-0"
                         data-slide="{{ $index }}"
                         role="tabpanel"
                         aria-label="Bild {{ $index + 1 }} von {{ count($images) }}"
                         aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
                        
                        <!-- Image -->
                        <img src="{{ asset($image['src']) }}" 
                             alt="{{ $image['alt'] }}"
                             class="w-full h-full object-cover"
                             loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                             draggable="false">
                        
                        <!-- Overlay Content -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end">
                            <div class="p-8 md:p-12 text-white max-w-2xl">
                                <h3 class="text-2xl md:text-3xl font-bold mb-3">{{ $image['title'] }}</h3>
                                <p class="text-lg opacity-90 leading-relaxed">{{ $image['description'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Navigation Controls -->
                <div class="absolute inset-0 flex items-center justify-between pointer-events-none z-20">
                    <!-- Previous Button -->
                    <button type="button" 
                            class="prev-btn pointer-events-auto ml-4 w-12 h-12 bg-white bg-opacity-95 hover:bg-opacity-100 rounded-full shadow-lg flex items-center justify-center text-medical-blue hover:text-trust-blue transition-all duration-700 ease-out hover:scale-105 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-50 border-2 border-white border-opacity-20"
                            aria-label="Vorheriges Bild">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <!-- Next Button -->
                    <button type="button" 
                            class="next-btn pointer-events-auto mr-4 w-12 h-12 bg-white bg-opacity-95 hover:bg-opacity-100 rounded-full shadow-lg flex items-center justify-center text-medical-blue hover:text-trust-blue transition-all duration-700 ease-out hover:scale-105 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-50 border-2 border-white border-opacity-20"
                            aria-label="Nächstes Bild">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Play/Pause Button -->
                <div class="absolute top-4 right-4">
                    <button type="button" 
                            class="play-pause-btn w-10 h-10 bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full shadow-soft flex items-center justify-center text-medical-blue hover:text-trust-blue transition-all duration-500 ease-out hover:scale-105 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-50"
                            aria-label="Slideshow pausieren/fortsetzen">
                        <!-- Pause Icon (shown when playing) -->
                        <svg class="pause-icon w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path>
                        </svg>
                        <!-- Play Icon (shown when paused) -->
                        <svg class="play-icon w-5 h-5 hidden" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Progress Dots with Navigation Arrows -->
                <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2">
                    <div class="flex items-center space-x-4" role="tablist" aria-label="Bildauswahl">
                        <!-- Previous Arrow (Small) -->
                        <button type="button" 
                                class="prev-btn-small w-8 h-8 bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full shadow-md flex items-center justify-center text-medical-blue hover:text-trust-blue transition-all duration-500 ease-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-75"
                                aria-label="Vorheriges Bild">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Dots -->
                        <div class="flex space-x-3">
                            @foreach($images as $index => $image)
                            <button type="button" 
                                    class="dot w-3 h-3 rounded-full transition-all duration-500 ease-out focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-75 {{ $index === 0 ? 'bg-white scale-125' : 'bg-white bg-opacity-50 hover:bg-opacity-75 hover:scale-110' }}"
                                    data-slide-to="{{ $index }}"
                                    role="tab"
                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-label="Zu Bild {{ $index + 1 }} wechseln">
                            </button>
                            @endforeach
                        </div>
                        
                        <!-- Next Arrow (Small) -->
                        <button type="button" 
                                class="next-btn-small w-8 h-8 bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full shadow-md flex items-center justify-center text-medical-blue hover:text-trust-blue transition-all duration-500 ease-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-75"
                                aria-label="Nächstes Bild">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-white bg-opacity-30">
                    <div class="progress-bar h-full bg-medical-blue transition-all duration-100 ease-linear" 
                         style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
/**
 * Medical Practice Slideshow with Accessibility and Touch Support
 * Enhanced with auto-play, keyboard navigation, and mobile gestures
 */
class MedicalSlideshow {
    constructor(container) {
        this.container = container;
        this.slides = container.querySelectorAll('.slide');
        this.dots = container.querySelectorAll('.dot');
        this.prevButtons = container.querySelectorAll('.prev-btn, .prev-btn-small');
        this.nextButtons = container.querySelectorAll('.next-btn, .next-btn-small');
        this.playPauseBtn = container.querySelector('.play-pause-btn');
        this.progressBar = container.querySelector('.progress-bar');
        this.liveRegion = document.getElementById('live-region');
        
        this.currentSlide = 0;
        this.totalSlides = this.slides.length;
        this.isPlaying = true;
        this.interval = parseInt(container.dataset.interval) || 5000;
        this.autoPlayTimer = null;
        this.progressTimer = null;
        
        // Touch/swipe support
        this.touchStartX = 0;
        this.touchEndX = 0;
        this.swipeThreshold = 50;
        
        this.init();
    }
    
    init() {
        if (this.totalSlides <= 1) return;
        
        this.setupEventListeners();
        this.setupKeyboardNavigation();
        this.setupTouchEvents();
        this.updateSlideVisibility();
        this.startAutoPlay();
        this.updateProgressBar();
        
        // Announce slideshow to screen readers
        this.announceToScreenReader(`Slideshow gestartet. ${this.totalSlides} Bilder verfügbar.`);
    }
    
    setupEventListeners() {
        // Navigation buttons
        this.prevButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.previousSlide();
            });
        });
        
        this.nextButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.nextSlide();
            });
        });
        
        // Play/pause button
        this.playPauseBtn?.addEventListener('click', (e) => {
            e.preventDefault();
            this.togglePlayPause();
        });
        
        // Dots navigation
        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', (e) => {
                e.preventDefault();
                this.goToSlide(index);
            });
        });
        
        // Pause on hover (accessibility)
        this.container.addEventListener('mouseenter', () => {
            if (this.isPlaying) this.pauseAutoPlay();
        });
        
        this.container.addEventListener('mouseleave', () => {
            if (this.isPlaying) this.startAutoPlay();
        });
        
        // Pause when tab becomes inactive
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.pauseAutoPlay();
            } else if (this.isPlaying) {
                this.startAutoPlay();
            }
        });
    }
    
    setupKeyboardNavigation() {
        this.container.addEventListener('keydown', (e) => {
            switch(e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    this.previousSlide();
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    this.nextSlide();
                    break;
                case ' ':
                case 'Enter':
                    if (e.target === this.playPauseBtn) {
                        e.preventDefault();
                        this.togglePlayPause();
                    }
                    break;
                case 'Home':
                    e.preventDefault();
                    this.goToSlide(0);
                    break;
                case 'End':
                    e.preventDefault();
                    this.goToSlide(this.totalSlides - 1);
                    break;
            }
        });
    }
    
    setupTouchEvents() {
        const slideContainer = this.container.querySelector('.slideshow-container');
        
        slideContainer.addEventListener('touchstart', (e) => {
            this.touchStartX = e.changedTouches[0].screenX;
            this.pauseAutoPlay(); // Pause during touch interaction
        }, { passive: true });
        
        slideContainer.addEventListener('touchend', (e) => {
            this.touchEndX = e.changedTouches[0].screenX;
            this.handleSwipeGesture();
            if (this.isPlaying) this.startAutoPlay(); // Resume if playing
        }, { passive: true });
    }
    
    handleSwipeGesture() {
        const swipeDistance = this.touchEndX - this.touchStartX;
        
        if (Math.abs(swipeDistance) > this.swipeThreshold) {
            if (swipeDistance > 0) {
                this.previousSlide();
                this.announceToScreenReader('Vorheriges Bild durch Wischen ausgewählt');
            } else {
                this.nextSlide();
                this.announceToScreenReader('Nächstes Bild durch Wischen ausgewählt');
            }
        }
    }
    
    nextSlide() {
        this.goToSlide((this.currentSlide + 1) % this.totalSlides);
    }
    
    previousSlide() {
        this.goToSlide((this.currentSlide - 1 + this.totalSlides) % this.totalSlides);
    }
    
    goToSlide(index) {
        if (index === this.currentSlide) return;
        
        this.currentSlide = index;
        this.updateSlideVisibility();
        this.updateDots();
        this.resetProgressBar();
        
        // Get current slide info for announcement
        const currentSlideElement = this.slides[this.currentSlide];
        const slideTitle = currentSlideElement.querySelector('h3')?.textContent || `Bild ${index + 1}`;
        this.announceToScreenReader(`${slideTitle}. Bild ${index + 1} von ${this.totalSlides}`);
    }
    
    updateSlideVisibility() {
        this.slides.forEach((slide, index) => {
            const isActive = index === this.currentSlide;
            slide.classList.toggle('active', isActive);
            slide.setAttribute('aria-hidden', !isActive);
            
            // Update loading attribute for performance
            const img = slide.querySelector('img');
            if (img && isActive) {
                img.loading = 'eager';
            }
        });
    }
    
    updateDots() {
        this.dots.forEach((dot, index) => {
            const isActive = index === this.currentSlide;
            dot.classList.toggle('bg-white', isActive);
            dot.classList.toggle('scale-125', isActive);
            dot.classList.toggle('bg-white', !isActive);
            dot.classList.toggle('bg-opacity-50', !isActive);
            dot.setAttribute('aria-selected', isActive);
        });
    }
    
    togglePlayPause() {
        this.isPlaying = !this.isPlaying;
        
        if (this.isPlaying) {
            this.startAutoPlay();
            this.announceToScreenReader('Slideshow wird fortgesetzt');
        } else {
            this.pauseAutoPlay();
            this.announceToScreenReader('Slideshow pausiert');
        }
        
        this.updatePlayPauseButton();
    }
    
    updatePlayPauseButton() {
        if (!this.playPauseBtn) return;
        
        const pauseIcon = this.playPauseBtn.querySelector('.pause-icon');
        const playIcon = this.playPauseBtn.querySelector('.play-icon');
        
        if (this.isPlaying) {
            pauseIcon?.classList.remove('hidden');
            playIcon?.classList.add('hidden');
            this.playPauseBtn.setAttribute('aria-label', 'Slideshow pausieren');
        } else {
            pauseIcon?.classList.add('hidden');
            playIcon?.classList.remove('hidden');
            this.playPauseBtn.setAttribute('aria-label', 'Slideshow fortsetzen');
        }
    }
    
    startAutoPlay() {
        if (!this.isPlaying || this.totalSlides <= 1) return;
        
        this.pauseAutoPlay(); // Clear existing timers
        
        this.autoPlayTimer = setTimeout(() => {
            this.nextSlide();
            this.startAutoPlay(); // Restart for next slide
        }, this.interval);
        
        this.updateProgressBar();
    }
    
    pauseAutoPlay() {
        if (this.autoPlayTimer) {
            clearTimeout(this.autoPlayTimer);
            this.autoPlayTimer = null;
        }
        if (this.progressTimer) {
            clearInterval(this.progressTimer);
            this.progressTimer = null;
        }
    }
    
    updateProgressBar() {
        if (!this.progressBar || !this.isPlaying) return;
        
        this.resetProgressBar();
        
        let progress = 0;
        const increment = 100 / (this.interval / 100);
        
        this.progressTimer = setInterval(() => {
            progress += increment;
            this.progressBar.style.width = `${Math.min(progress, 100)}%`;
            
            if (progress >= 100) {
                clearInterval(this.progressTimer);
                this.progressTimer = null;
            }
        }, 100);
    }
    
    resetProgressBar() {
        if (this.progressBar) {
            this.progressBar.style.width = '0%';
        }
        if (this.progressTimer) {
            clearInterval(this.progressTimer);
            this.progressTimer = null;
        }
    }
    
    announceToScreenReader(message) {
        if (this.liveRegion) {
            this.liveRegion.textContent = message;
        }
    }
    
    // Public methods for external control
    play() {
        if (!this.isPlaying) {
            this.togglePlayPause();
        }
    }
    
    pause() {
        if (this.isPlaying) {
            this.togglePlayPause();
        }
    }
    
    destroy() {
        this.pauseAutoPlay();
        // Remove event listeners if needed
    }
}

// Initialize slideshow when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const slideshowContainer = document.querySelector('.medical-slideshow');
    if (slideshowContainer) {
        window.medicalSlideshow = new MedicalSlideshow(slideshowContainer);
    }
});

// Handle reduced motion preference
if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.addEventListener('DOMContentLoaded', function() {
        if (window.medicalSlideshow) {
            window.medicalSlideshow.pause();
        }
    });
}
</script>

<style>
/* Slideshow specific styles */
.medical-slideshow .slide {
    opacity: 0;
    z-index: 0;
    transition: opacity 0.7s ease-in-out;
}

.medical-slideshow .slide.active {
    opacity: 1;
    z-index: 1;
}

/* Ensure images fill the container properly */
.medical-slideshow .slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

/* Navigation controls should always be on top */
.medical-slideshow .prev-btn,
.medical-slideshow .next-btn {
    z-index: 30 !important;
    position: relative;
}

/* Make sure buttons are always visible */
.medical-slideshow .prev-btn,
.medical-slideshow .next-btn {
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(4px);
}

/* Touch feedback for mobile */
@media (hover: none) and (pointer: coarse) {
    .medical-slideshow .prev-btn:active,
    .medical-slideshow .next-btn:active {
        transform: scale(0.95);
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .medical-slideshow .slide {
        transition: none !important;
    }
    
    .progress-bar {
        transition: none !important;
    }
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .medical-slideshow .prev-btn,
    .medical-slideshow .next-btn,
    .medical-slideshow .play-pause-btn {
        background-color: white;
        border: 2px solid #1a5490;
    }
    
    .medical-slideshow .dot {
        border: 1px solid white;
    }
}
</style>