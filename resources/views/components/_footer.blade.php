<footer class="bg-gradient-to-br from-warm-gray-50 to-gentle-blue border-t border-warm-gray-100" role="contentinfo" aria-label="Website Footer">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Practice Info -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('messages.common.practice_name') }}</h3>
                <p class="text-gray-600 mb-4">
                    {{ __('messages.home.about_text') }}
                </p>
                <address class="space-y-2 text-sm text-gray-600 not-italic">
                    <p><strong>{{ __('messages.contact.address_title') }}:</strong> {{ __('messages.common.address') }}</p>
                    <p><strong>{{ __('messages.contact.phone_title') }}:</strong> 
                        <a href="tel:{{ __('messages.common.phone_number') }}" class="hover:text-medical-blue transition-colors">{{ __('messages.common.phone_number') }}</a>
                    </p>
                    <p><strong>{{ __('messages.contact.email_title') }}:</strong> 
                        <a href="mailto:{{ __('messages.common.email_address') }}" class="hover:text-medical-blue transition-colors">{{ __('messages.common.email_address') }}</a>
                    </p>
                </address>
            </div>

            <!-- Quick Links -->
            <nav aria-labelledby="footer-nav-heading">
                <h4 id="footer-nav-heading" class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Navigation</h4>
                <ul class="space-y-2" role="list">
                    <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-medical-blue text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-opacity-50 rounded">{{ __('messages.nav.home') }}</a></li>
                    <li><a href="{{ route('services') }}" class="text-gray-600 hover:text-medical-blue text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-opacity-50 rounded">{{ __('messages.nav.services') }}</a></li>
                    <li><a href="{{ route('team') }}" class="text-gray-600 hover:text-medical-blue text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-opacity-50 rounded">{{ __('messages.nav.team') }}</a></li>
                    <li><a href="{{ route('faq') }}" class="text-gray-600 hover:text-medical-blue text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-opacity-50 rounded">{{ __('messages.nav.faq') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-medical-blue text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-opacity-50 rounded">{{ __('messages.nav.contact') }}</a></li>
                </ul>
            </nav>

            <!-- Opening Hours -->
            <div role="complementary" aria-labelledby="footer-hours-heading">
                <h4 id="footer-hours-heading" class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">{{ __('messages.home.opening_hours_title') }}</h4>
                <div class="space-y-1 text-sm text-gray-600" role="table" aria-label="Öffnungszeiten">
                    <div class="flex justify-between" role="row">
                        <span role="cell">{{ __('messages.opening_hours.monday_friday') }}:</span>
                        <span role="cell">{{ __('messages.opening_hours.time_mf') }}</span>
                    </div>
                    <div class="flex justify-between" role="row">
                        <span role="cell">{{ __('messages.opening_hours.saturday') }}:</span>
                        <span role="cell">{{ __('messages.opening_hours.time_sat') }}</span>
                    </div>
                    <div class="flex justify-between" role="row">
                        <span role="cell">{{ __('messages.opening_hours.sunday') }}:</span>
                        <span role="cell">{{ __('messages.opening_hours.closed') }}</span>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('contact') }}#contact-form" 
                       class="inline-block bg-gradient-to-r from-medical-blue to-trust-blue text-white px-6 py-3 rounded-2xl text-sm font-medium hover:shadow-card transition-all duration-500 ease-out focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-80 shadow-soft transform hover:-translate-y-1">
                        {{ __('messages.nav.book_appointment') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-warm-gray-200 mt-10 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} {{ __('messages.common.practice_name') }}. {{ __('messages.common.all_rights_reserved') }}.
                </p>
                <nav aria-label="Legal links" class="flex space-x-6 mt-4 md:mt-0">
                    <a href="{{ route('legal.privacy') }}" class="text-sm text-gray-500 hover:text-medical-blue transition-colors focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-opacity-50 rounded">{{ __('messages.legal.nav.privacy') }}</a>
                    <a href="{{ route('legal.imprint') }}" class="text-sm text-gray-500 hover:text-medical-blue transition-colors focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-opacity-50 rounded">{{ __('messages.legal.nav.imprint') }}</a>
                    <a href="{{ route('legal.terms') }}" class="text-sm text-gray-500 hover:text-medical-blue transition-colors focus:outline-none focus:ring-2 focus:ring-medical-blue focus:ring-opacity-50 rounded">{{ __('messages.legal.nav.terms') }}</a>
                </nav>
            </div>
        </div>
    </div>
</footer>