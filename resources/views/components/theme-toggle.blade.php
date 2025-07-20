{{--
Theme Toggle Component
Modern toggle switch for dark/light theme with accessibility support
--}}

@props(['size' => 'normal'])

@php
    $themeService = app(\App\Services\ThemeService::class);
    $currentTheme = $themeService->getCurrentTheme();
    $oppositeTheme = $currentTheme->getOpposite();
    
    $sizeClasses = match($size) {
        'small' => 'w-12 h-6',
        'large' => 'w-16 h-8',
        default => 'w-14 h-7'
    };
    
    $iconSizeClasses = match($size) {
        'small' => 'w-3 h-3',
        'large' => 'w-5 h-5',
        default => 'w-4 h-4'
    };
@endphp

<div class="theme-toggle-container relative" role="group" aria-label="{{ __('messages.theme.toggle_label') }}">
    <!-- Toggle Switch -->
    <button type="button" 
            id="theme-toggle-button"
            class="theme-toggle-button {{ $sizeClasses }} relative inline-flex items-center rounded-full transition-all duration-500 ease-out focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2 focus:ring-offset-white bg-warm-gray-200 dark:bg-dark-bg-tertiary hover:shadow-gentle dark:hover:shadow-dark-gentle"
            aria-label="{{ __('messages.theme.toggle_to', ['theme' => $oppositeTheme->getDisplayName()]) }}"
            aria-pressed="{{ $currentTheme->isDark() ? 'true' : 'false' }}"
            data-current-theme="{{ $currentTheme->value }}"
            data-opposite-theme="{{ $oppositeTheme->value }}">
        
        <!-- Background Track -->
        <span class="sr-only">{{ __('messages.theme.current_theme', ['theme' => $currentTheme->getDisplayName()]) }}</span>
        
        <!-- Sliding Circle with Icon -->
        <span class="theme-toggle-slider {{ $currentTheme->isDark() ? 'translate-x-7' : 'translate-x-0' }} pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white dark:bg-dark-text-primary shadow-card transition-all duration-500 ease-out relative">
            <div class="absolute inset-0 flex items-center justify-center">
                <!-- Light Theme Icon (Sun) -->
                <svg class="theme-icon-light {{ $iconSizeClasses }} {{ $currentTheme->isLight() ? 'opacity-100 scale-100' : 'opacity-0 scale-75' }} text-medical-blue transition-all duration-300 ease-out absolute" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                
                <!-- Dark Theme Icon (Moon) -->
                <svg class="theme-icon-dark {{ $iconSizeClasses }} {{ $currentTheme->isDark() ? 'opacity-100 scale-100' : 'opacity-0 scale-75' }} text-dark-medical-blue dark:text-dark-accent-teal transition-all duration-300 ease-out absolute" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </div>
        </span>
    </button>
    
    <!-- Optional Label -->
    @if($attributes->get('showLabel', false))
        <span class="ml-3 text-sm font-medium text-warm-gray-700 dark:text-dark-text-secondary">
            {{ __('messages.theme.current_theme', ['theme' => $currentTheme->getDisplayName()]) }}
        </span>
    @endif
</div>

<!-- Theme Toggle Styles -->
<style>
/* Theme toggle specific styles */
.theme-toggle-button {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
}

.dark .theme-toggle-button {
    background: linear-gradient(135deg, var(--color-dark-bg-tertiary) 0%, var(--color-dark-surface) 100%);
}

.theme-toggle-button:hover {
    background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
}

.dark .theme-toggle-button:hover {
    background: linear-gradient(135deg, var(--color-dark-surface) 0%, var(--color-dark-border-light) 100%);
}

/* Enhanced focus state for theme toggle */
.theme-toggle-button:focus {
    box-shadow: 0 0 0 3px var(--color-medical-blue), 
                0 0 0 6px rgba(59, 123, 184, 0.2);
}

.dark .theme-toggle-button:focus {
    box-shadow: 0 0 0 3px var(--color-dark-medical-blue), 
                0 0 0 6px rgba(96, 165, 250, 0.2);
}

/* Smooth transitions for theme switching */
.theme-toggle-slider {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1),
                background-color 0.3s ease,
                box-shadow 0.3s ease;
}

/* Icon transition effects */
.theme-icon-light,
.theme-icon-dark {
    transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .theme-toggle-button {
        border: 2px solid var(--color-medical-blue);
    }
    
    .dark .theme-toggle-button {
        border: 2px solid var(--color-dark-medical-blue);
    }
    
    .theme-toggle-slider {
        border: 1px solid var(--color-warm-gray-400);
    }
    
    .dark .theme-toggle-slider {
        border: 1px solid var(--color-dark-border);
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .theme-toggle-slider,
    .theme-icon-light,
    .theme-icon-dark {
        transition: none !important;
    }
}

/* Mobile touch optimization */
@media (max-width: 768px) {
    .theme-toggle-button {
        min-width: 44px;
        min-height: 44px;
        touch-action: manipulation;
    }
}
</style>

<!-- Theme Toggle JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle-button');
    if (!themeToggle) return;

    // Initialize theme state
    const themeData = @json($themeService->getThemeData());
    let currentTheme = themeData.current;

    // Toggle theme function
    function toggleTheme() {
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        setTheme(newTheme);
    }

    // Set theme function
    function setTheme(theme) {
        currentTheme = theme;
        
        // Update DOM
        document.documentElement.classList.toggle('dark', theme === 'dark');
        
        // Update button state
        updateToggleButton(theme);
        
        // Update meta theme-color
        updateMetaThemeColor(theme);
        
        // Store preference using consistent key
        localStorage.setItem('theme_preference', theme);
        
        // Clean up any conflicting storage keys
        localStorage.removeItem('medical-theme-preference');
        
        // Update session via fetch (non-blocking)
        fetch('/api/theme/set', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify({ theme: theme })
        }).catch(() => {
            // Silently handle errors - theme is already set in localStorage
        });
        
        // Announce to screen readers
        announceThemeChange(theme);
    }

    // Update toggle button appearance
    function updateToggleButton(theme) {
        const slider = themeToggle.querySelector('.theme-toggle-slider');
        const lightIcon = themeToggle.querySelector('.theme-icon-light');
        const darkIcon = themeToggle.querySelector('.theme-icon-dark');
        
        // Update slider position
        if (theme === 'dark') {
            slider.classList.add('translate-x-7');
            slider.classList.remove('translate-x-0');
        } else {
            slider.classList.add('translate-x-0');
            slider.classList.remove('translate-x-7');
        }
        
        // Update icon visibility
        if (theme === 'dark') {
            lightIcon.classList.add('opacity-0', 'scale-75');
            lightIcon.classList.remove('opacity-100', 'scale-100');
            darkIcon.classList.add('opacity-100', 'scale-100');
            darkIcon.classList.remove('opacity-0', 'scale-75');
        } else {
            lightIcon.classList.add('opacity-100', 'scale-100');
            lightIcon.classList.remove('opacity-0', 'scale-75');
            darkIcon.classList.add('opacity-0', 'scale-75');
            darkIcon.classList.remove('opacity-100', 'scale-100');
        }
        
        // Update ARIA attributes
        themeToggle.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
        const oppositeTheme = theme === 'dark' ? 'light' : 'dark';
        const oppositeThemeName = oppositeTheme === 'dark' ? '{{ __("messages.theme.dark") }}' : '{{ __("messages.theme.light") }}';
        themeToggle.setAttribute('aria-label', `{{ __("messages.theme.toggle_to") }}`.replace(':theme', oppositeThemeName));
    }

    // Update meta theme-color
    function updateMetaThemeColor(theme) {
        const metaThemeColor = document.getElementById('theme-color-meta');
        if (metaThemeColor) {
            metaThemeColor.setAttribute('content', themeData.meta_colors[theme]);
        }
    }

    // Announce theme change to screen readers
    function announceThemeChange(theme) {
        const liveRegion = document.getElementById('live-region');
        if (liveRegion) {
            const themeName = theme === 'dark' ? '{{ __("messages.theme.dark") }}' : '{{ __("messages.theme.light") }}';
            liveRegion.textContent = `{{ __("messages.theme.switched_to") }}`.replace(':theme', themeName);
        }
    }

    // Initialize theme from system preference if no preference set
    function initializeSystemTheme() {
        // Clean up any conflicting storage keys first
        if (localStorage.getItem('medical-theme-preference')) {
            const oldTheme = localStorage.getItem('medical-theme-preference');
            localStorage.setItem('theme_preference', oldTheme);
            localStorage.removeItem('medical-theme-preference');
        }
        
        if (!localStorage.getItem('theme_preference') && !themeData.session_preference) {
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                setTheme('dark');
            }
        }
    }

    // Listen for system theme changes
    function setupSystemThemeListener() {
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', (e) => {
                // Only auto-switch if user hasn't set a manual preference
                if (!localStorage.getItem('theme_preference')) {
                    setTheme(e.matches ? 'dark' : 'light');
                }
            });
        }
    }

    // Event listeners
    themeToggle.addEventListener('click', toggleTheme);
    
    // Keyboard support
    themeToggle.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggleTheme();
        }
    });

    // Initialize
    initializeSystemTheme();
    setupSystemThemeListener();
    updateToggleButton(currentTheme);
});
</script>