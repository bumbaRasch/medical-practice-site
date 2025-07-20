/**
 * Medical Practice Services Slideshow
 * 
 * Modern, accessible slideshow with auto-play, touch support, and keyboard navigation
 * Features:
 * - Auto-advance with pause on interaction
 * - Touch/swipe support for mobile devices
 * - Keyboard navigation (arrow keys, space bar)
 * - Progress indicators and progress bar
 * - Play/pause functionality
 * - Accessibility compliant (ARIA labels, focus management)
 * 
 * Context: Laravel 12+ Medical Practice Website
 */

class MedicalSlideshow {
    constructor(container) {
        this.container = container;
        this.slides = container.querySelectorAll('.slide');
        this.dots = container.querySelectorAll('.dot');
        this.prevBtn = container.querySelector('.prev-btn');
        this.nextBtn = container.querySelector('.next-btn');
        this.prevBtnSmall = container.querySelector('.prev-btn-small');
        this.nextBtnSmall = container.querySelector('.next-btn-small');
        this.playPauseBtn = container.querySelector('.play-pause-btn');
        this.progressBar = container.querySelector('.progress-bar');
        this.playIcon = container.querySelector('.play-icon');
        this.pauseIcon = container.querySelector('.pause-icon');
        
        // Configuration
        this.currentSlide = 0;
        this.totalSlides = this.slides.length;
        this.autoPlay = container.dataset.autoPlay === 'true';
        this.interval = parseInt(container.dataset.interval) || 5000;
        this.isPlaying = this.autoPlay;
        this.autoAdvanceTimer = null;
        this.progressTimer = null;
        this.isTransitioning = false;
        
        // Touch/swipe support
        this.touchStartX = 0;
        this.touchEndX = 0;
        this.minSwipeDistance = 50;
        
        // Initialize slideshow
        this.init();
    }
    
    init() {
        if (this.totalSlides <= 1) return;
        
        // Set up initial state
        this.updateSlideState();
        this.updatePlayPauseButton();
        
        // Bind event listeners
        this.bindEvents();
        
        // Start auto-advance if enabled
        if (this.autoPlay) {
            this.startAutoAdvance();
        }
        
        // Announce slideshow initialization to screen readers
        this.announceToScreenReader('Slideshow geladen. Verwenden Sie die Pfeiltasten oder Schaltflächen zur Navigation.');
    }
    
    bindEvents() {
        // Navigation buttons with debugging
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', (e) => {
                e.preventDefault();
                console.log('Previous button clicked');
                this.previousSlide();
            });
        }
        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                console.log('Next button clicked');
                this.nextSlide();
            });
        }
        if (this.playPauseBtn) {
            this.playPauseBtn.addEventListener('click', () => this.togglePlayPause());
        }
        
        // Small navigation buttons (below photos)
        if (this.prevBtnSmall) {
            this.prevBtnSmall.addEventListener('click', (e) => {
                e.preventDefault();
                console.log('Previous button (small) clicked');
                this.previousSlide();
            });
        }
        if (this.nextBtnSmall) {
            this.nextBtnSmall.addEventListener('click', (e) => {
                e.preventDefault();
                console.log('Next button (small) clicked');
                this.nextSlide();
            });
        }
        
        // Dot indicators
        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => this.goToSlide(index));
        });
        
        // Keyboard navigation
        this.container.addEventListener('keydown', (e) => this.handleKeyboard(e));
        
        // Touch/swipe support
        this.container.addEventListener('touchstart', (e) => this.handleTouchStart(e), { passive: true });
        this.container.addEventListener('touchend', (e) => this.handleTouchEnd(e), { passive: true });
        
        // Mouse events for auto-pause
        this.container.addEventListener('mouseenter', () => this.pauseOnInteraction());
        this.container.addEventListener('mouseleave', () => this.resumeAfterInteraction());
        
        // Focus events for accessibility
        this.container.addEventListener('focusin', () => this.pauseOnInteraction());
        this.container.addEventListener('focusout', () => this.resumeAfterInteraction());
        
        // Visibility API - pause when tab is not visible
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.pauseAutoAdvance();
            } else if (this.isPlaying && this.autoPlay) {
                this.startAutoAdvance();
            }
        });
        
        // Reduced motion support
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            this.autoPlay = false;
            this.isPlaying = false;
            this.pauseAutoAdvance();
        }
    }
    
    goToSlide(index, direction = 'auto') {
        if (this.isTransitioning || index === this.currentSlide || index < 0 || index >= this.totalSlides) {
            return;
        }
        
        this.isTransitioning = true;
        const previousSlide = this.currentSlide;
        this.currentSlide = index;
        
        // Update slide visibility
        this.updateSlideState();
        
        // Reset progress bar
        this.resetProgressBar();
        
        // Announce slide change to screen readers
        const slideNumber = index + 1;
        this.announceToScreenReader(`Bild ${slideNumber} von ${this.totalSlides}`);
        
        // Allow next transition after animation completes
        setTimeout(() => {
            this.isTransitioning = false;
        }, 700); // Match CSS transition duration
    }
    
    nextSlide() {
        console.log(`Going to next slide from ${this.currentSlide}`);
        const nextIndex = (this.currentSlide + 1) % this.totalSlides;
        this.goToSlide(nextIndex, 'next');
        this.resetAutoAdvance();
    }
    
    previousSlide() {
        console.log(`Going to previous slide from ${this.currentSlide}`);
        const prevIndex = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        this.goToSlide(prevIndex, 'prev');
        this.resetAutoAdvance();
    }
    
    updateSlideState() {
        // Update slide visibility
        this.slides.forEach((slide, index) => {
            const isActive = index === this.currentSlide;
            slide.classList.toggle('active', isActive);
            slide.setAttribute('aria-hidden', !isActive);
        });
        
        // Update dot indicators
        this.dots.forEach((dot, index) => {
            const isActive = index === this.currentSlide;
            if (isActive) {
                dot.classList.add('bg-white', 'scale-125');
                dot.classList.remove('bg-opacity-50');
            } else {
                dot.classList.remove('bg-white', 'scale-125');
                dot.classList.add('bg-white', 'bg-opacity-50');
            }
            dot.setAttribute('aria-selected', isActive);
        });
    }
    
    startAutoAdvance() {
        if (!this.autoPlay || this.autoAdvanceTimer) return;
        
        this.autoAdvanceTimer = setInterval(() => {
            this.nextSlide();
        }, this.interval);
        
        this.startProgressBar();
    }
    
    pauseAutoAdvance() {
        if (this.autoAdvanceTimer) {
            clearInterval(this.autoAdvanceTimer);
            this.autoAdvanceTimer = null;
        }
        this.pauseProgressBar();
    }
    
    resetAutoAdvance() {
        if (this.isPlaying && this.autoPlay) {
            this.pauseAutoAdvance();
            this.startAutoAdvance();
        }
    }
    
    togglePlayPause() {
        this.isPlaying = !this.isPlaying;
        
        if (this.isPlaying && this.autoPlay) {
            this.startAutoAdvance();
            this.announceToScreenReader('Slideshow wird fortgesetzt');
        } else {
            this.pauseAutoAdvance();
            this.announceToScreenReader('Slideshow pausiert');
        }
        
        this.updatePlayPauseButton();
    }
    
    updatePlayPauseButton() {
        if (!this.playPauseBtn) return;
        
        if (this.isPlaying) {
            this.playIcon?.classList.add('hidden');
            this.pauseIcon?.classList.remove('hidden');
            this.playPauseBtn.setAttribute('aria-label', 'Slideshow pausieren');
        } else {
            this.playIcon?.classList.remove('hidden');
            this.pauseIcon?.classList.add('hidden');
            this.playPauseBtn.setAttribute('aria-label', 'Slideshow fortsetzen');
        }
    }
    
    startProgressBar() {
        if (!this.progressBar) return;
        
        this.resetProgressBar();
        
        let progress = 0;
        const increment = 100 / (this.interval / 100);
        
        this.progressTimer = setInterval(() => {
            progress += increment;
            if (progress >= 100) {
                progress = 100;
                clearInterval(this.progressTimer);
            }
            this.progressBar.style.width = `${progress}%`;
        }, 100);
    }
    
    pauseProgressBar() {
        if (this.progressTimer) {
            clearInterval(this.progressTimer);
            this.progressTimer = null;
        }
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
    
    pauseOnInteraction() {
        if (this.isPlaying) {
            this.pauseAutoAdvance();
        }
    }
    
    resumeAfterInteraction() {
        if (this.isPlaying && this.autoPlay) {
            // Small delay to prevent immediate restart
            setTimeout(() => {
                if (this.isPlaying) {
                    this.startAutoAdvance();
                }
            }, 500);
        }
    }
    
    handleKeyboard(e) {
        // Only handle keyboard events when slideshow is focused
        if (!this.container.contains(document.activeElement)) return;
        
        switch (e.key) {
            case 'ArrowLeft':
                e.preventDefault();
                this.previousSlide();
                break;
            case 'ArrowRight':
                e.preventDefault();
                this.nextSlide();
                break;
            case ' ':
            case 'Spacebar':
                e.preventDefault();
                this.togglePlayPause();
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
    }
    
    handleTouchStart(e) {
        this.touchStartX = e.changedTouches[0].screenX;
    }
    
    handleTouchEnd(e) {
        this.touchEndX = e.changedTouches[0].screenX;
        this.handleSwipe();
    }
    
    handleSwipe() {
        const distance = this.touchStartX - this.touchEndX;
        const absDistance = Math.abs(distance);
        
        if (absDistance < this.minSwipeDistance) return;
        
        if (distance > 0) {
            // Swiped left - next slide
            this.nextSlide();
        } else {
            // Swiped right - previous slide
            this.previousSlide();
        }
    }
    
    announceToScreenReader(message) {
        // Create temporary announcement element for screen readers
        const announcement = document.createElement('div');
        announcement.setAttribute('aria-live', 'polite');
        announcement.setAttribute('aria-atomic', 'true');
        announcement.className = 'sr-only';
        announcement.textContent = message;
        
        document.body.appendChild(announcement);
        
        // Remove after announcement
        setTimeout(() => {
            if (announcement.parentNode) {
                announcement.parentNode.removeChild(announcement);
            }
        }, 1000);
    }
    
    // Public API for external control
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
    
    getCurrentSlide() {
        return this.currentSlide;
    }
    
    getTotalSlides() {
        return this.totalSlides;
    }
    
    // Cleanup method
    destroy() {
        this.pauseAutoAdvance();
        this.resetProgressBar();
        
        // Remove event listeners
        this.prevBtn?.removeEventListener('click', () => this.previousSlide());
        this.nextBtn?.removeEventListener('click', () => this.nextSlide());
        this.playPauseBtn?.removeEventListener('click', () => this.togglePlayPause());
    }
}

// Initialize all slideshows when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const slideshows = document.querySelectorAll('.medical-slideshow');
    const instances = [];
    
    slideshows.forEach(container => {
        const slideshow = new MedicalSlideshow(container);
        instances.push(slideshow);
    });
    
    // Make instances available globally for debugging
    window.medicalSlideshows = instances;
});

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = MedicalSlideshow;
}