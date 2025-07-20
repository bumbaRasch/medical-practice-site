@extends('layouts.app')

@section('title', __('messages.home.page_title'))
@section('description', __('messages.home.page_meta_description'))

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-gentle-blue via-medical-light-blue to-healing-mint py-32 overflow-hidden" aria-labelledby="hero-heading">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 opacity-5" aria-hidden="true">
        <svg class="absolute top-20 left-10 w-8 h-8 text-green-500 opacity-30 animate-pulse" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
        <svg class="absolute bottom-20 right-16 w-6 h-6 text-blue-500 opacity-20 animate-pulse delay-1000" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="absolute top-1/3 right-1/4 w-4 h-4 bg-blue-300 rounded-full opacity-10 animate-pulse delay-500" aria-hidden="true"></div>
        <div class="absolute bottom-1/4 left-1/3 w-5 h-5 bg-green-300 rounded-full opacity-15 animate-pulse delay-700" aria-hidden="true"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center">
            <div class="inline-flex items-center px-6 py-3 bg-white bg-opacity-95 rounded-full text-sm font-medium text-trust-blue mb-8 shadow-card backdrop-blur-sm">
                <svg class="w-5 h-5 mr-2 text-soft-green" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                Ihr vertrauensvoller Hausarzt seit über 20 Jahren
            </div>
            
            <h1 id="hero-heading" class="text-4xl md:text-6xl lg:text-7xl font-bold text-warm-gray-800 mb-6 leading-tight tracking-tight">
                {{ __('messages.home.hero_title') }}
            </h1>
            <p class="text-xl md:text-2xl lg:text-3xl text-warm-gray-600 mb-12 max-w-4xl mx-auto leading-relaxed font-light">
                {{ __('messages.home.hero_subtitle') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}#contact-form" 
                   class="group bg-gradient-to-r from-medical-blue to-trust-blue text-white px-10 py-5 rounded-3xl text-lg font-semibold hover:shadow-floating transform hover:-translate-y-1 transition-all duration-600 ease-out focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-80 shadow-card"
                   aria-describedby="hero-cta-description">
                    <span class="flex items-center justify-center">
                        {{ __('messages.home.hero_cta') }}
                        <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform duration-400 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </a>
                <a href="{{ route('services') }}" 
                   class="group bg-white bg-opacity-95 border-2 border-trust-blue text-trust-blue px-10 py-5 rounded-3xl text-lg font-semibold hover:bg-trust-blue hover:text-white transition-all duration-500 backdrop-blur-sm focus:outline-none focus:ring-4 focus:ring-trust-blue focus:ring-opacity-50 shadow-soft hover:shadow-card">
                    {{ __('messages.home.hero_services_cta') }}
                </a>
            </div>
            <span id="hero-cta-description" class="sr-only">Springen zum Kontaktformular um einen Termin zu vereinbaren</span>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-20 bg-gradient-to-br from-warm-gray-25 to-gentle-blue" aria-labelledby="about-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 id="about-heading" class="text-3xl font-bold text-gray-900 mb-6">
                    {{ __('messages.home.about_title') }}
                </h2>
                <p class="text-lg text-gray-600 mb-6">
                    {{ __('messages.home.about_text') }}
                </p>
                <ul class="space-y-3" role="list" aria-label="Unsere Stärken">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-medical-blue mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">{{ __('messages.home.experience_years') }}</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-medical-blue mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">{{ __('messages.home.modern_technology') }}</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-medical-blue mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">{{ __('messages.home.empathetic_care') }}</span>
                    </li>
                </ul>
            </div>
            <div class="bg-gradient-to-br from-gentle-blue to-medical-light-blue rounded-3xl p-10 shadow-card border border-white border-opacity-70 backdrop-blur-sm" role="complementary" aria-labelledby="appointment-heading">
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-medical-blue to-trust-blue rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-soft" aria-hidden="true">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 id="appointment-heading" class="text-2xl font-bold text-warm-gray-900 mb-4">{{ __('messages.home.quick_appointment') }}</h3>
                    <p class="text-warm-gray-700 mb-6 leading-relaxed">
                        {{ __('messages.home.quick_appointment_text') }}
                    </p>
                    <a href="{{ route('contact') }}#contact-form" 
                       class="group inline-flex items-center bg-gradient-to-r from-medical-blue to-trust-blue text-white px-10 py-5 rounded-3xl font-semibold hover:shadow-floating transform hover:-translate-y-1 transition-all duration-600 ease-out focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-80 shadow-card">
                        {{ __('messages.home.quick_appointment_cta') }}
                        <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform duration-400 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-24 bg-gradient-to-br from-healing-mint to-gentle-blue" aria-labelledby="benefits-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 id="benefits-heading" class="text-4xl font-bold text-warm-gray-900 mb-4">
                {{ __('messages.home.benefits_title') }}
            </h2>
            <p class="text-xl text-warm-gray-600 max-w-3xl mx-auto">
                Entdecken Sie, was unsere Praxis so besonders macht
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8" role="list" aria-label="Unsere Vorteile">
            <!-- Modern Equipment -->
            <article class="group bg-white rounded-3xl p-10 text-center shadow-card hover:shadow-floating transition-all duration-700 ease-out transform hover:-translate-y-2 focus-within:ring-4 focus-within:ring-medical-blue focus-within:ring-opacity-30 border border-white border-opacity-60" role="listitem">
                <div class="relative">
                    <div class="w-20 h-20 bg-gradient-to-br from-medical-blue to-trust-blue rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:scale-105 transition-transform duration-600 ease-out shadow-soft" aria-hidden="true">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-soft-green rounded-full opacity-20 group-hover:opacity-100 transition-opacity duration-500 ease-out" aria-hidden="true"></div>
                </div>
                <h3 class="text-xl font-bold text-warm-gray-900 mb-3">
                    {{ __('messages.benefits.modern_equipment.title') }}
                </h3>
                <p class="text-warm-gray-600 leading-relaxed">
                    {{ __('messages.benefits.modern_equipment.description') }}
                </p>
            </article>

            <!-- Experienced Team -->
            <article class="group bg-white rounded-3xl p-10 text-center shadow-card hover:shadow-floating transition-all duration-700 ease-out transform hover:-translate-y-2 focus-within:ring-4 focus-within:ring-medical-blue focus-within:ring-opacity-30 border border-white border-opacity-60" role="listitem">
                <div class="relative">
                    <div class="w-20 h-20 bg-gradient-to-br from-soft-green to-gentle-green rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:scale-105 transition-transform duration-600 ease-out shadow-soft" aria-hidden="true">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-trust-blue rounded-full opacity-20 group-hover:opacity-100 transition-opacity duration-500 ease-out" aria-hidden="true"></div>
                </div>
                <h3 class="text-xl font-bold text-warm-gray-900 mb-3">
                    {{ __('messages.benefits.experienced_team.title') }}
                </h3>
                <p class="text-warm-gray-600 leading-relaxed">
                    {{ __('messages.benefits.experienced_team.description') }}
                </p>
            </article>

            <!-- Personal Care -->
            <article class="group bg-white rounded-3xl p-10 text-center shadow-card hover:shadow-floating transition-all duration-700 ease-out transform hover:-translate-y-2 focus-within:ring-4 focus-within:ring-medical-blue focus-within:ring-opacity-30 border border-white border-opacity-60" role="listitem">
                <div class="relative">
                    <div class="w-20 h-20 bg-gradient-to-br from-trust-blue to-healing-blue rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:scale-105 transition-transform duration-600 ease-out shadow-soft" aria-hidden="true">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-healing-blue rounded-full opacity-20 group-hover:opacity-100 transition-opacity duration-500 ease-out" aria-hidden="true"></div>
                </div>
                <h3 class="text-xl font-bold text-warm-gray-900 mb-3">
                    {{ __('messages.benefits.personal_care.title') }}
                </h3>
                <p class="text-warm-gray-600 leading-relaxed">
                    {{ __('messages.benefits.personal_care.description') }}
                </p>
            </article>

            <!-- Short Waiting -->
            <article class="group bg-white rounded-3xl p-10 text-center shadow-card hover:shadow-floating transition-all duration-700 ease-out transform hover:-translate-y-2 focus-within:ring-4 focus-within:ring-medical-blue focus-within:ring-opacity-30 border border-white border-opacity-60" role="listitem">
                <div class="relative">
                    <div class="w-20 h-20 bg-gradient-to-br from-soft-blue to-medical-blue rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:scale-105 transition-transform duration-600 ease-out shadow-soft" aria-hidden="true">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-soft-blue rounded-full opacity-20 group-hover:opacity-100 transition-opacity duration-500 ease-out" aria-hidden="true"></div>
                </div>
                <h3 class="text-xl font-bold text-warm-gray-900 mb-3">
                    {{ __('messages.benefits.short_waiting.title') }}
                </h3>
                <p class="text-warm-gray-600 leading-relaxed">
                    {{ __('messages.benefits.short_waiting.description') }}
                </p>
            </article>
        </div>
    </div>
</section>

<!-- Opening Hours Section -->
<section class="py-20 bg-gradient-to-br from-warm-gray-25 to-gentle-blue" aria-labelledby="hours-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-center lg:text-left">
                <h2 id="hours-heading" class="text-3xl font-bold text-gray-900 mb-6">
                    {{ __('messages.home.opening_hours_title') }}
                </h2>
                <p class="text-lg text-gray-600 mb-8">
                    {{ __("messages.home.opening_hours_text") }}
                </p>
                <a href="{{ route('contact') }}" 
                   class="inline-block bg-gradient-to-r from-medical-blue to-trust-blue text-white px-8 py-4 rounded-2xl font-semibold hover:shadow-card transform hover:-translate-y-1 transition-all duration-500 ease-out focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-80 shadow-soft">
                    Kontakt aufnehmen
                </a>
            </div>
            <div class="bg-white border border-white border-opacity-60 rounded-3xl p-10 shadow-card backdrop-blur-sm" role="complementary" aria-labelledby="hours-table-heading">
                <h3 id="hours-table-heading" class="text-xl font-semibold text-gray-900 mb-6 text-center">{{ __("messages.home.opening_hours_title") }}</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-700">{{ __('messages.opening_hours.monday_friday') }}</span>
                        <span class="text-medical-blue font-semibold">{{ __('messages.opening_hours.time_mf') }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-700">{{ __('messages.opening_hours.saturday') }}</span>
                        <span class="text-medical-blue font-semibold">{{ __('messages.opening_hours.time_sat') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-gray-700">{{ __('messages.opening_hours.sunday') }}</span>
                        <span class="text-gray-500">{{ __('messages.opening_hours.closed') }}</span>
                    </div>
                </div>
                <div class="mt-8 p-6 bg-medical-light-blue rounded-2xl border border-white border-opacity-50">
                    <p class="text-sm text-gray-700 text-center">
                        <strong>{{ __("messages.common.emergency") }}?</strong> {{ __("messages.home.emergency_info") }} <strong>{{ __("messages.home.emergency_number") }}</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-medical-blue to-trust-blue" aria-labelledby="final-cta-heading">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 id="final-cta-heading" class="text-3xl font-bold text-white mb-4">
            {{ __('messages.home.final_cta_title') }}
        </h2>
        <p class="text-xl text-blue-100 mb-8">
            {{ __('messages.home.final_cta_text') }}
        </p>
        <a href="{{ route('contact') }}#contact-form" 
           class="bg-white text-medical-blue px-10 py-5 rounded-3xl text-lg font-semibold hover:bg-warm-gray-50 transition-all duration-500 ease-out focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-80 shadow-floating transform hover:-translate-y-1">
            {{ __("messages.home.quick_appointment_cta") }}
        </a>
    </div>
</section>
@endsection