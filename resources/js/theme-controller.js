/**
 * Theme Controller - Medical Practice Theme Management
 * Handles dark/light theme switching with system preference detection
 * and smooth transitions
 */
class MedicalThemeController {
    constructor() {
        this.currentTheme = 'light';
        this.storageKey = 'theme_preference';
        this.isInitialized = false;
        this.mediaQuery = null;
        this.observers = new Map();
        
        // Only initialize if no other theme toggle is present
        if (!document.getElementById('theme-toggle-button')) {
            this.init();
        }
    }
    
    init() {
        if (this.isInitialized) return;
        
        this.setupMediaQuery();
        this.loadStoredTheme();
        this.applyTheme(this.currentTheme, false); // No transition on initial load
        this.setupToggleListeners();
        this.setupStorageListener();
        this.setupKeyboardShortcuts();
        
        this.isInitialized = true;
        this.announceToScreenReader(`Theme initialized: ${this.getThemeDisplayName(this.currentTheme)}`);
    }
    
    /**
     * Setup system theme preference detection
     */
    setupMediaQuery() {
        if (window.matchMedia) {
            this.mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            this.mediaQuery.addEventListener('change', (e) => {
                // Only auto-switch if user hasn't set a manual preference
                if (!this.hasManualPreference()) {
                    this.setTheme(e.matches ? 'dark' : 'light', true);
                }
            });
        }
    }
    
    /**
     * Load theme from storage or system preference
     */
    loadStoredTheme() {
        // Clean up any conflicting storage keys first
        if (localStorage.getItem('medical-theme-preference')) {
            const oldTheme = localStorage.getItem('medical-theme-preference');
            if (this.isValidTheme(oldTheme)) {
                localStorage.setItem(this.storageKey, oldTheme);
            }
            localStorage.removeItem('medical-theme-preference');
        }
        
        // 1. Check localStorage for manual preference
        const storedTheme = localStorage.getItem(this.storageKey);
        if (storedTheme && this.isValidTheme(storedTheme)) {
            this.currentTheme = storedTheme;
            return;
        }
        
        // 2. Check system preference
        if (this.mediaQuery && this.mediaQuery.matches) {
            this.currentTheme = 'dark';
            return;
        }
        
        // 3. Default to light
        this.currentTheme = 'light';
    }
    
    /**
     * Set theme with optional transition
     */
    setTheme(theme, animated = true) {
        if (!this.isValidTheme(theme) || theme === this.currentTheme) {
            return;
        }
        
        const oldTheme = this.currentTheme;
        this.currentTheme = theme;
        
        this.applyTheme(theme, animated);
        this.storeTheme(theme);
        this.updateToggleButtons();
        this.updateMetaThemeColor();
        this.notifyThemeChange(oldTheme, theme);
        
        // Update server-side session
        this.syncWithServer(theme);
    }
    
    /**
     * Toggle between light and dark themes
     */
    toggleTheme() {
        const newTheme = this.currentTheme === 'light' ? 'dark' : 'light';
        this.setTheme(newTheme, true);
    }
    
    /**
     * Apply theme to DOM
     */
    applyTheme(theme, animated = true) {
        const html = document.documentElement;
        const body = document.body;
        
        // Add transition class if animated
        if (animated) {
            html.classList.add('theme-transitioning');
            body.classList.add('theme-transitioning');
        }
        
        // Apply theme class
        if (theme === 'dark') {
            html.classList.add('dark');
            body.classList.add('dark');
        } else {
            html.classList.remove('dark');
            body.classList.remove('dark');
        }
        
        // Remove transition class after animation
        if (animated) {
            setTimeout(() => {
                html.classList.remove('theme-transitioning');
                body.classList.remove('theme-transitioning');
            }, 300);
        }
        
        // Update color-scheme for better browser integration
        html.style.colorScheme = theme;
    }
    
    /**
     * Store theme preference
     */
    storeTheme(theme) {
        try {
            localStorage.setItem(this.storageKey, theme);
        } catch (e) {
            console.warn('Failed to store theme preference:', e);
        }
    }
    
    /**
     * Update all theme toggle buttons
     */
    updateToggleButtons() {
        const toggles = document.querySelectorAll('.theme-toggle-button');
        toggles.forEach(toggle => this.updateToggleButton(toggle));
    }
    
    /**
     * Update individual toggle button
     */
    updateToggleButton(button) {
        if (!button) return;
        
        const slider = button.querySelector('.theme-toggle-slider');
        const lightIcon = button.querySelector('.theme-icon-light');
        const darkIcon = button.querySelector('.theme-icon-dark');
        
        if (!slider || !lightIcon || !darkIcon) return;
        
        // Update slider position
        if (this.currentTheme === 'dark') {
            slider.classList.add('translate-x-7');
            slider.classList.remove('translate-x-0');
        } else {
            slider.classList.add('translate-x-0');
            slider.classList.remove('translate-x-7');
        }
        
        // Update icon visibility
        if (this.currentTheme === 'dark') {
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
        button.setAttribute('aria-pressed', this.currentTheme === 'dark' ? 'true' : 'false');
        
        // Update data attributes
        button.setAttribute('data-current-theme', this.currentTheme);
        button.setAttribute('data-opposite-theme', this.currentTheme === 'dark' ? 'light' : 'dark');
    }
    
    /**
     * Update meta theme-color
     */
    updateMetaThemeColor() {
        const metaThemeColor = document.getElementById('theme-color-meta');
        if (metaThemeColor) {
            const color = this.currentTheme === 'dark' ? '#0f172a' : '#3B7BB8';
            metaThemeColor.setAttribute('content', color);
        }
    }

    /**
     * Setup event listeners for theme toggles
     */
    setupToggleListeners() {
        // Handle click events on theme toggle buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.theme-toggle-button')) {
                e.preventDefault();
                this.toggleTheme();
            }
        });
        
        // Handle keyboard events
        document.addEventListener('keydown', (e) => {
            const toggle = e.target.closest('.theme-toggle-button');
            if (toggle && (e.key === 'Enter' || e.key === ' ')) {
                e.preventDefault();
                this.toggleTheme();
            }
        });
    }

    /**
     * Setup cross-tab synchronization
     */
    setupStorageListener() {
        window.addEventListener('storage', (e) => {
            if (e.key === this.storageKey && e.newValue !== this.currentTheme) {
                if (this.isValidTheme(e.newValue)) {
                    this.currentTheme = e.newValue;
                    this.applyTheme(this.currentTheme, true);
                    this.updateToggleButtons();
                    this.updateMetaThemeColor();
                }
            }
        });
    }

    /**
     * Setup keyboard shortcuts
     */
    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + Shift + T to toggle theme
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'T') {
                e.preventDefault();
                this.toggleTheme();
            }
        });
    }

    /**
     * Sync theme with server
     */
    async syncWithServer(theme) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) return;
            
            await fetch('/api/theme/set', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ theme })
            });
        } catch (error) {
            console.warn('Failed to sync theme with server:', error);
        }
    }

    /**
     * Notify about theme change
     */
    notifyThemeChange(oldTheme, newTheme) {
        // Dispatch custom event
        const event = new CustomEvent('themechange', {
            detail: { oldTheme, newTheme }
        });
        document.dispatchEvent(event);
        
        // Announce to screen readers
        this.announceToScreenReader(`Theme changed to ${this.getThemeDisplayName(newTheme)}`);
    }

    /**
     * Announce to screen readers
     */
    announceToScreenReader(message) {
        const liveRegion = document.getElementById('live-region');
        if (liveRegion) {
            liveRegion.textContent = message;
        }
    }

    /**
     * Check if user has set a manual theme preference
     */
    hasManualPreference() {
        return localStorage.getItem(this.storageKey) !== null;
    }

    /**
     * Validate theme value
     */
    isValidTheme(theme) {
        return typeof theme === 'string' && ['light', 'dark'].includes(theme);
    }

    /**
     * Get display name for theme
     */
    getThemeDisplayName(theme) {
        return theme === 'dark' ? 'Dark' : 'Light';
    }

    /**
     * Get current theme
     */
    getCurrentTheme() {
        return this.currentTheme;
    }

    /**
     * Check if current theme is dark
     */
    isDark() {
        return this.currentTheme === 'dark';
    }

    /**
     * Check if current theme is light
     */
    isLight() {
        return this.currentTheme === 'light';
    }

    /**
     * Force refresh of theme state
     */
    refresh() {
        this.loadStoredTheme();
        this.applyTheme(this.currentTheme, false);
        this.updateToggleButtons();
        this.updateMetaThemeColor();
    }

    /**
     * Get theme debug information
     */
    getDebugInfo() {
        return {
            currentTheme: this.currentTheme,
            storedTheme: localStorage.getItem(this.storageKey),
            systemPreference: this.mediaQuery ? (this.mediaQuery.matches ? 'dark' : 'light') : 'unknown',
            hasManualPreference: this.hasManualPreference(),
            isInitialized: this.isInitialized
        };
    }

    /**
     * Cleanup resources
     */
    destroy() {
        if (this.mediaQuery) {
            this.mediaQuery.removeEventListener('change', this.handleSystemThemeChange);
        }
        
        this.observers.forEach(observer => observer.disconnect());
        this.observers.clear();
        
        this.isInitialized = false;
    }
}

// Auto-initialize theme controller when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.medicalThemeController = new MedicalThemeController();
    });
} else {
    window.medicalThemeController = new MedicalThemeController();
}

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    if (window.medicalThemeController) {
        window.medicalThemeController.destroy();
    }
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = MedicalThemeController;
}