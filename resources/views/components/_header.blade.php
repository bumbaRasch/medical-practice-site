<header class="bg-white shadow-card border-b border-warm-gray-100" role="banner">
    <nav id="navigation" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" role="navigation" aria-label="Hauptnavigation">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-medical-blue" aria-label="{{ __('messages.common.practice_name') }} - Zur Startseite">
                    {{ __('messages.common.practice_name') }}
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <ul class="ml-10 flex items-baseline space-x-8" role="menubar" aria-label="Hauptmenü">
                    <li role="none">
                        <a href="{{ route('home') }}" 
                           class="text-gray-700 hover:text-medical-blue px-3 py-2 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2 rounded
                                  {{ request()->routeIs('home') ? 'text-medical-blue border-medical-blue' : '' }}"
                           role="menuitem"
                           {{ request()->routeIs('home') ? 'aria-current="page"' : '' }}>
                            {{ __('messages.nav.home') }}
                        </a>
                    </li>
                    <li role="none">
                        <a href="{{ route('services') }}" 
                           class="text-gray-700 hover:text-medical-blue px-3 py-2 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2 rounded
                                  {{ request()->routeIs('services') ? 'text-medical-blue border-medical-blue' : '' }}"
                           role="menuitem"
                           {{ request()->routeIs('services') ? 'aria-current="page"' : '' }}>
                            {{ __('messages.nav.services') }}
                        </a>
                    </li>
                    <li role="none">
                        <a href="{{ route('team') }}" 
                           class="text-gray-700 hover:text-medical-blue px-3 py-2 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2 rounded
                                  {{ request()->routeIs('team') ? 'text-medical-blue border-medical-blue' : '' }}"
                           role="menuitem"
                           {{ request()->routeIs('team') ? 'aria-current="page"' : '' }}>
                            {{ __('messages.nav.team') }}
                        </a>
                    </li>
                    <li role="none">
                        <a href="{{ route('faq') }}" 
                           class="text-gray-700 hover:text-medical-blue px-3 py-2 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2 rounded
                                  {{ request()->routeIs('faq') ? 'text-medical-blue border-medical-blue' : '' }}"
                           role="menuitem"
                           {{ request()->routeIs('faq') ? 'aria-current="page"' : '' }}>
                            {{ __('messages.nav.faq') }}
                        </a>
                    </li>
                    <li role="none">
                        <a href="{{ route('contact') }}" 
                           class="text-gray-700 hover:text-medical-blue px-3 py-2 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2 rounded
                                  {{ request()->routeIs('contact') ? 'text-medical-blue border-medical-blue' : '' }}"
                           role="menuitem"
                           {{ request()->routeIs('contact') ? 'aria-current="page"' : '' }}>
                            {{ __('messages.nav.contact') }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- CTA Button, Language Switcher, Theme Toggle -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- CTA Button -->
                <a href="{{ route('contact') }}#contact-form" 
                   class="bg-gradient-to-r from-medical-blue to-trust-blue text-white px-8 py-3 rounded-2xl text-sm font-medium hover:shadow-card transition-all duration-500 ease-out focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 shadow-soft transform hover:-translate-y-1"
                   aria-label="Termin vereinbaren - Zum Kontaktformular">
                    {{ __('messages.nav.book_appointment') }}
                </a>
                
                <!-- Language Controls -->
                <div class="flex items-center">
                    <!-- Modern Language Toggle Switch -->
                    <div class="relative" role="group" aria-label="Sprachauswahl">
                        <div class="relative inline-flex items-center bg-warm-gray-100 dark:bg-dark-bg-tertiary rounded-full p-1 transition-all duration-500 ease-out hover:shadow-gentle dark:hover:shadow-dark-gentle">
                            <!-- Background slider -->
                            <div class="absolute inset-1 bg-gradient-to-r from-medical-blue to-trust-blue dark:from-dark-medical-blue dark:to-dark-medical-blue-light rounded-full shadow-soft transition-all duration-500 ease-out transform
                                        {{ app()->getLocale() == 'de' ? 'translate-x-0' : 'translate-x-full' }}"
                                 style="width: calc(50% - 4px);"></div>
                            
                            <!-- Language Options -->
                            @foreach(\App\Enums\Locale::cases() as $locale)
                                <a href="{{ url()->current() }}?lang={{ $locale->value }}" 
                                   class="relative z-10 px-4 py-2 text-sm font-bold transition-all duration-500 ease-out rounded-full min-w-[44px] text-center
                                          focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-dark-medical-blue dark:focus:ring-offset-dark-bg-primary
                                          {{ app()->getLocale() == $locale->value 
                                              ? 'text-white' 
                                              : 'text-warm-gray-600 hover:text-medical-blue dark:text-dark-text-muted dark:hover:text-dark-medical-blue-light' }}"
                                   aria-label="Sprache wechseln zu {{ $locale->nativeName() }}"
                                   {{ app()->getLocale() == $locale->value ? 'aria-current="true"' : '' }}>
                                    {{ $locale->shortCode() }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Theme Toggle -->
                <div class="flex items-center">
                    @include('components.theme-toggle', ['size' => 'normal'])
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" 
                        class="mobile-menu-button text-gray-700 hover:text-medical-blue focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2 rounded p-2"
                        aria-label="{{ __('messages.nav.menu_open') }}"
                        aria-expanded="false"
                        aria-controls="mobile-menu"
                        aria-haspopup="true">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span class="sr-only">Mobilmenü öffnen</span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="mobile-menu hidden md:hidden" role="menu" aria-labelledby="mobile-menu-button">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-medical-gray">
                <a href="{{ route('home') }}" 
                   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-medical-blue hover:bg-medical-light-blue rounded-md focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2"
                   role="menuitem"
                   {{ request()->routeIs('home') ? 'aria-current="page"' : '' }}>
                    {{ __('messages.nav.home') }}
                </a>
                <a href="{{ route('services') }}" 
                   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-medical-blue hover:bg-medical-light-blue rounded-md focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2"
                   role="menuitem"
                   {{ request()->routeIs('services') ? 'aria-current="page"' : '' }}>
                    {{ __('messages.nav.services') }}
                </a>
                <a href="{{ route('team') }}" 
                   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-medical-blue hover:bg-medical-light-blue rounded-md focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2"
                   role="menuitem"
                   {{ request()->routeIs('team') ? 'aria-current="page"' : '' }}>
                    {{ __('messages.nav.team') }}
                </a>
                <a href="{{ route('faq') }}" 
                   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-medical-blue hover:bg-medical-light-blue rounded-md focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2"
                   role="menuitem"
                   {{ request()->routeIs('faq') ? 'aria-current="page"' : '' }}>
                    {{ __('messages.nav.faq') }}
                </a>
                <a href="{{ route('contact') }}" 
                   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-medical-blue hover:bg-medical-light-blue rounded-md focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2"
                   role="menuitem"
                   {{ request()->routeIs('contact') ? 'aria-current="page"' : '' }}>
                    {{ __('messages.nav.contact') }}
                </a>
                
                <!-- Mobile Language Controls -->
                <div class="flex justify-center items-center pt-2 pb-2">
                    <!-- Mobile Language Toggle Switch -->
                    <div class="relative" role="group" aria-label="Mobile Sprachauswahl">
                        <div class="relative inline-flex items-center bg-warm-gray-100 dark:bg-dark-bg-tertiary rounded-full p-1 transition-all duration-500 ease-out hover:shadow-gentle dark:hover:shadow-dark-gentle">
                            <!-- Background slider -->
                            <div class="absolute inset-1 bg-gradient-to-r from-medical-blue to-trust-blue dark:from-dark-medical-blue dark:to-dark-medical-blue-light rounded-full shadow-soft transition-all duration-500 ease-out transform
                                        {{ app()->getLocale() == 'de' ? 'translate-x-0' : 'translate-x-full' }}"
                                 style="width: calc(50% - 4px);"></div>
                            
                            <!-- Language Options -->
                            @foreach(\App\Enums\Locale::cases() as $locale)
                                <a href="{{ url()->current() }}?lang={{ $locale->value }}" 
                                   class="relative z-10 px-4 py-2 text-sm font-bold transition-all duration-500 ease-out rounded-full min-w-[48px] text-center
                                          focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-dark-medical-blue dark:focus:ring-offset-dark-bg-primary
                                          {{ app()->getLocale() == $locale->value 
                                              ? 'text-white' 
                                              : 'text-warm-gray-600 hover:text-medical-blue dark:text-dark-text-muted dark:hover:text-dark-medical-blue-light' }}"
                                   aria-label="Mobile Sprache wechseln zu {{ $locale->nativeName() }}"
                                   {{ app()->getLocale() == $locale->value ? 'aria-current="true"' : '' }}>
                                    {{ $locale->shortCode() }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Theme Toggle -->
                <div class="flex justify-center items-center pt-2 pb-2">
                    @include('components.theme-toggle', ['size' => 'normal'])
                </div>
                
                <a href="{{ route('contact') }}#contact-form" 
                   class="block px-3 py-2 mt-4 bg-medical-blue text-white text-center rounded-md font-medium hover:bg-trust-blue focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2"
                   role="menuitem"
                   aria-label="Mobile Termin vereinbaren - Zum Kontaktformular">
                    {{ __('messages.nav.book_appointment') }}
                </a>
            </div>
        </div>
    </nav>
</header>

<script>
// Accessible mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            
            // Toggle menu visibility
            mobileMenu.classList.toggle('hidden');
            
            // Update ARIA attributes
            mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
            mobileMenuButton.setAttribute('aria-label', 
                !isExpanded ? 'Menü schließen' : '{{ __("messages.nav.menu_open") }}'
            );
            
            // Announce to screen readers
            const liveRegion = document.getElementById('live-region');
            if (liveRegion) {
                liveRegion.textContent = !isExpanded ? 'Menü geöffnet' : 'Menü geschlossen';
            }
            
            // Focus management
            if (!isExpanded) {
                // Focus first menu item when opening
                const firstMenuItem = mobileMenu.querySelector('a[role="menuitem"]');
                if (firstMenuItem) {
                    firstMenuItem.focus();
                }
            }
        });
        
        // Close menu on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                mobileMenuButton.setAttribute('aria-label', '{{ __("messages.nav.menu_open") }}');
                mobileMenuButton.focus();
                
                const liveRegion = document.getElementById('live-region');
                if (liveRegion) {
                    liveRegion.textContent = 'Menü geschlossen';
                }
            }
        });
    }
});
</script>