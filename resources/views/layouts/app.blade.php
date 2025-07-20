<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __('messages.home.page_title'))</title>
    <meta name="description" content="@yield('description', __('messages.home.page_meta_description'))">
    
    <!-- Favicons and App Icons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    
    <!-- Theme Colors (Dynamic based on theme) -->
    @php
        $themeService = app(\App\Services\ThemeService::class);
        $currentTheme = $themeService->getCurrentTheme();
        $themeClass = $themeService->getThemeClass();
        $metaThemeColor = $themeService->getMetaThemeColor();
    @endphp
    <meta name="theme-color" content="{{ $metaThemeColor }}" id="theme-color-meta">
    <meta name="msapplication-TileColor" content="{{ $metaThemeColor }}">
    <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/theme-controller.js'])
    
    <!-- Theme Detection Script (Inline for instant theme application) -->
    <script>
        // Immediately apply theme to prevent flash of wrong theme
        (function() {
            const storedTheme = localStorage.getItem('theme_preference');
            const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = storedTheme || (systemPrefersDark ? 'dark' : 'light');
            
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.style.colorScheme = 'dark';
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.style.colorScheme = 'light';
            }
        })();
    </script>
</head>
<body class="{{ $themeClass }} bg-white text-warm-gray-900 font-sans antialiased dark:bg-dark-bg-primary dark:text-dark-text-primary">
    <!-- Skip Links for Accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-medical-blue text-white px-4 py-2 rounded-lg font-medium z-50 focus:z-50">
        Zum Hauptinhalt springen
    </a>
    <a href="#navigation" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-40 bg-medical-blue text-white px-4 py-2 rounded-lg font-medium z-50 focus:z-50">
        Zur Navigation springen
    </a>
    
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        @include('components._header')

        <!-- Main Content -->
        <main id="main-content" class="flex-grow" role="main">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('components._footer')
    </div>
    
    <!-- Live Region for Announcements -->
    <div id="live-region" class="sr-only" aria-live="polite" aria-atomic="true"></div>
    
    <!-- Global Enhancement System -->
    <script>
    /**
     * Medical Practice Global Enhancement System
     * Provides loading states, micro-interactions, and UX improvements
     */
    class MedicalEnhancementSystem {
        constructor() {
            this.isInitialized = false;
            this.pageLoadStart = performance.now();
            this.observers = new Map();
            this.liveRegion = document.getElementById('live-region');
            
            this.init();
        }
        
        init() {
            if (this.isInitialized) return;
            
            this.createGlobalElements();
            this.setupPageLoading();
            this.setupScrollProgress();
            this.setupIntersectionObserver();
            this.setupNavigationEnhancements();
            this.setupFormEnhancements();
            this.setupImageLazyLoading();
            this.setupFloatingActionButton();
            this.setupToastSystem();
            this.setupRippleEffects();
            this.setupKeyboardShortcuts();
            
            this.isInitialized = true;
            this.trackPerformance();
        }
        
        createGlobalElements() {
            // Create scroll progress indicator
            const scrollIndicator = document.createElement('div');
            scrollIndicator.className = 'scroll-indicator';
            scrollIndicator.innerHTML = '<div class="scroll-progress"></div>';
            document.body.appendChild(scrollIndicator);
            
            // Create floating action button for quick contact
            const fab = document.createElement('a');
            fab.href = '{{ route("contact") }}#contact-form';
            fab.className = 'fab';
            fab.innerHTML = `
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            `;
            fab.setAttribute('aria-label', 'Schnell Kontakt aufnehmen');
            fab.setAttribute('title', 'Termin vereinbaren');
            document.body.appendChild(fab);
            
            // Create toast container
            const toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 1000; pointer-events: none;';
            document.body.appendChild(toastContainer);
        }
        
        setupPageLoading() {
            // Hide page loader when content is ready
            window.addEventListener('load', () => {
                const pageLoadTime = performance.now() - this.pageLoadStart;
                
                // Minimum loading time for smooth UX
                const minLoadTime = 800;
                const remainingTime = Math.max(0, minLoadTime - pageLoadTime);
                
                setTimeout(() => {
                    document.body.classList.add('page-loaded');
                    this.announceToScreenReader('Seite vollständig geladen');
                }, remainingTime);
            });
            
            // Add page entrance animation
            document.body.classList.add('page-enter');
            
            // Activate entrance animation
            requestAnimationFrame(() => {
                document.body.classList.add('page-enter-active');
            });
        }
        
        setupScrollProgress() {
            const progressBar = document.querySelector('.scroll-progress');
            if (!progressBar) return;
            
            const updateProgress = () => {
                const windowHeight = window.innerHeight;
                const documentHeight = document.documentElement.scrollHeight - windowHeight;
                const scrollTop = window.scrollY;
                const scrollProgress = (scrollTop / documentHeight) * 100;
                
                progressBar.style.width = Math.min(Math.max(scrollProgress, 0), 100) + '%';
            };
            
            // Throttled scroll handler
            let ticking = false;
            const handleScroll = () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        updateProgress();
                        this.updateFloatingActionButton();
                        ticking = false;
                    });
                    ticking = true;
                }
            };
            
            window.addEventListener('scroll', handleScroll, { passive: true });
            updateProgress(); // Initial update
        }
        
        setupIntersectionObserver() {
            // Reveal animations on scroll
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });
            
            // Observe all reveal elements
            const revealElements = document.querySelectorAll('.reveal');
            revealElements.forEach(el => revealObserver.observe(el));
            
            this.observers.set('reveal', revealObserver);
        }
        
        setupNavigationEnhancements() {
            // Add nav-link class to navigation items
            const navLinks = document.querySelectorAll('nav a[href]');
            navLinks.forEach(link => {
                link.classList.add('nav-link');
                
                // Add active state based on current page
                const currentPath = window.location.pathname;
                const linkPath = new URL(link.href).pathname;
                
                if (currentPath === linkPath || (currentPath === '/' && linkPath === '/')) {
                    link.classList.add('active');
                }
            });
            
            // Mobile menu is handled in _header.blade.php to avoid conflicts
            // This space reserved for other navigation enhancements if needed
        }
        
        setupFormEnhancements() {
            // Add form-field class to form containers
            const formGroups = document.querySelectorAll('.group, form > div');
            formGroups.forEach(group => {
                if (group.querySelector('input, select, textarea')) {
                    group.classList.add('form-field');
                }
            });
            
            // Enhanced focus states
            const formElements = document.querySelectorAll('input, select, textarea, button');
            formElements.forEach(element => {
                element.classList.add('focus-enhanced');
            });
        }
        
        setupImageLazyLoading() {
            // Enhanced lazy loading with intersection observer
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        
                        if (img.dataset.src) {
                            img.classList.add('loading');
                            img.src = img.dataset.src;
                            
                            img.onload = () => {
                                img.classList.remove('loading');
                                img.classList.add('loaded');
                            };
                            
                            img.onerror = () => {
                                img.classList.remove('loading');
                                img.alt = 'Bild konnte nicht geladen werden';
                            };
                            
                            imageObserver.unobserve(img);
                        }
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '50px'
            });
            
            // Observe lazy images
            const lazyImages = document.querySelectorAll('img[data-src]');
            lazyImages.forEach(img => {
                img.classList.add('image-lazy');
                imageObserver.observe(img);
            });
            
            this.observers.set('image', imageObserver);
        }
        
        updateFloatingActionButton() {
            const fab = document.querySelector('.fab');
            if (!fab) return;
            
            const scrollTop = window.scrollY;
            const shouldShow = scrollTop > 300;
            
            if (shouldShow && !fab.classList.contains('show')) {
                fab.classList.add('show');
            } else if (!shouldShow && fab.classList.contains('show')) {
                fab.classList.remove('show');
            }
        }
        
        setupFloatingActionButton() {
            const fab = document.querySelector('.fab');
            if (!fab) return;
            
            // Add ripple effect to FAB
            fab.addEventListener('click', (e) => {
                this.createRipple(e, fab);
            });
            
            // Add tooltip behavior
            fab.addEventListener('mouseenter', () => {
                this.showTooltip(fab, fab.getAttribute('title'));
            });
            
            fab.addEventListener('mouseleave', () => {
                this.hideTooltip();
            });
        }
        
        setupToastSystem() {
            // Auto-show toasts based on URL parameters or session storage
            const urlParams = new URLSearchParams(window.location.search);
            const successMessage = urlParams.get('success') || sessionStorage.getItem('toast-success');
            const errorMessage = urlParams.get('error') || sessionStorage.getItem('toast-error');
            
            if (successMessage) {
                this.showToast(successMessage, 'success');
                sessionStorage.removeItem('toast-success');
            }
            
            if (errorMessage) {
                this.showToast(errorMessage, 'error');
                sessionStorage.removeItem('toast-error');
            }
        }
        
        showToast(message, type = 'info', duration = 5000) {
            const container = document.getElementById('toast-container');
            if (!container) return;
            
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.style.pointerEvents = 'auto';
            
            const icon = this.getToastIcon(type);
            toast.innerHTML = `
                <div class="flex items-start">
                    <div class="flex-shrink-0 mr-3">
                        ${icon}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">${message}</p>
                    </div>
                    <button class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            container.appendChild(toast);
            
            // Show toast
            requestAnimationFrame(() => {
                toast.classList.add('show');
            });
            
            // Auto-hide after duration
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
            }, duration);
            
            // Announce to screen readers
            this.announceToScreenReader(message);
        }
        
        getToastIcon(type) {
            const icons = {
                success: '<svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
                error: '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                warning: '<svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                info: '<svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>'
            };
            return icons[type] || icons.info;
        }
        
        setupRippleEffects() {
            // Add ripple effect to buttons
            const buttons = document.querySelectorAll('button, .btn, a[role="button"]');
            buttons.forEach(button => {
                button.classList.add('ripple');
                button.addEventListener('click', (e) => {
                    this.createRipple(e, button);
                });
            });
        }
        
        createRipple(event, element) {
            const rect = element.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;
            
            const ripple = document.createElement('span');
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transform: scale(0);
                animation: ripple-animation 0.6s linear;
                left: ${x}px;
                top: ${y}px;
                width: ${size}px;
                height: ${size}px;
                pointer-events: none;
            `;
            
            element.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        }
        
        setupKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                // Alt + C for contact
                if (e.altKey && e.key === 'c') {
                    e.preventDefault();
                    window.location.href = '{{ route("contact") }}';
                }
                
                // Alt + H for home
                if (e.altKey && e.key === 'h') {
                    e.preventDefault();
                    window.location.href = '{{ route("home") }}';
                }
                
                // Alt + S for services
                if (e.altKey && e.key === 's') {
                    e.preventDefault();
                    window.location.href = '{{ route("services") }}';
                }
                
                // Escape to close modals/overlays
                if (e.key === 'Escape') {
                    this.closeOverlays();
                }
            });
        }
        
        closeOverlays() {
            // Close any open overlays, modals, or dropdowns
            const overlays = document.querySelectorAll('.modal, .dropdown-open, .overlay');
            overlays.forEach(overlay => {
                overlay.classList.remove('show', 'open', 'dropdown-open');
            });
        }
        
        showTooltip(element, text) {
            if (!text) return;
            
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = text;
            tooltip.style.cssText = `
                position: absolute;
                background: rgba(0, 0, 0, 0.8);
                color: white;
                padding: 8px 12px;
                border-radius: 6px;
                font-size: 14px;
                white-space: nowrap;
                z-index: 1001;
                opacity: 0;
                transition: opacity 0.3s;
                pointer-events: none;
            `;
            
            document.body.appendChild(tooltip);
            
            const rect = element.getBoundingClientRect();
            tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = (rect.top - tooltip.offsetHeight - 10) + 'px';
            
            requestAnimationFrame(() => {
                tooltip.style.opacity = '1';
            });
            
            this.currentTooltip = tooltip;
        }
        
        hideTooltip() {
            if (this.currentTooltip) {
                this.currentTooltip.style.opacity = '0';
                setTimeout(() => {
                    if (this.currentTooltip && this.currentTooltip.parentNode) {
                        this.currentTooltip.remove();
                    }
                    this.currentTooltip = null;
                }, 300);
            }
        }
        
        trackPerformance() {
            // Track Core Web Vitals and loading performance
            const navigationEntry = performance.getEntriesByType('navigation')[0];
            const loadTime = performance.now() - this.pageLoadStart;
            
            // Log performance metrics for development
            if (window.location.hostname === 'localhost' || window.location.hostname.includes('dev')) {
                console.log('Medical Practice Performance Metrics:', {
                    pageLoadTime: Math.round(loadTime),
                    domContentLoaded: Math.round(navigationEntry.domContentLoadedEventEnd - navigationEntry.domContentLoadedEventStart),
                    timeToInteractive: Math.round(loadTime)
                });
            }
            
            // Send to analytics if available
            if (typeof gtag !== 'undefined') {
                gtag('event', 'page_performance', {
                    event_category: 'performance',
                    load_time: Math.round(loadTime),
                    page_path: window.location.pathname
                });
            }
        }
        
        announceToScreenReader(message) {
            if (this.liveRegion) {
                this.liveRegion.textContent = message;
            }
        }
        
        // Public API
        showSuccessToast(message) {
            this.showToast(message, 'success');
        }
        
        showErrorToast(message) {
            this.showToast(message, 'error');
        }
        
        showWarningToast(message) {
            this.showToast(message, 'warning');
        }
        
        showInfoToast(message) {
            this.showToast(message, 'info');
        }
        
        destroy() {
            // Clean up observers and event listeners
            this.observers.forEach(observer => observer.disconnect());
            this.observers.clear();
        }
    }
    
    // Initialize global enhancement system
    document.addEventListener('DOMContentLoaded', function() {
        window.medicalEnhancementSystem = new MedicalEnhancementSystem();
    });
    
    // Enhanced link prefetching for better perceived performance
    document.addEventListener('mouseover', function(e) {
        if (e.target.tagName === 'A' && e.target.href && e.target.hostname === window.location.hostname) {
            const link = document.createElement('link');
            link.rel = 'prefetch';
            link.href = e.target.href;
            document.head.appendChild(link);
        }
    }, { once: true, passive: true });
    </script>
    
    <!-- Page-specific scripts -->
    @stack('scripts')
</body>
</html>