@extends('layouts.app')

@section('title', __('messages.contact.page_title') . ' - ' . __('messages.common.practice_name'))
@section('description', __('messages.contact.page_meta_description'))

@section('content')
<!-- Page Header -->
<section class="relative bg-gradient-to-br from-gentle-blue via-medical-light-blue to-healing-mint py-24 overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 opacity-10">
        <svg class="absolute top-10 right-10 w-24 h-24 text-trust-blue animate-pulse" fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center">
            <div class="inline-flex items-center px-6 py-3 bg-white bg-opacity-95 rounded-full text-sm font-medium text-trust-blue mb-8 shadow-card backdrop-blur-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                </svg>
                Wir freuen uns auf Ihren Besuch
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-warm-gray-800 mb-6 tracking-tight">
                {{ __('messages.contact.page_title') }}
            </h1>
            <p class="text-xl md:text-2xl text-warm-gray-600 max-w-3xl mx-auto leading-relaxed font-light">
                {{ __('messages.contact.page_subtitle') }}
            </p>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="py-20 bg-gradient-to-br from-warm-gray-25 to-gentle-blue">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Details -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-8">{{ __('messages.contact.contact_info_title') }}</h2>
                
                <div class="space-y-6">
                    <!-- Address -->
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-medical-blue mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">{{ __('messages.contact.address_title') }}</h3>
                            <p class="text-gray-600">{{ __('messages.common.address') }}</p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-medical-blue mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">{{ __('messages.contact.phone_title') }}</h3>
                            <a href="tel:{{ __('messages.common.phone_number') }}" class="text-medical-blue hover:text-blue-600">
                                {{ __('messages.common.phone_number') }}
                            </a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-medical-blue mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">{{ __('messages.contact.email_title') }}</h3>
                            <a href="mailto:{{ __('messages.common.email_address') }}" class="text-medical-blue hover:text-blue-600">
                                {{ __('messages.common.email_address') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Opening Hours -->
                <div class="mt-10 p-8 bg-gradient-to-br from-gentle-blue to-medical-light-blue rounded-3xl shadow-card border border-white border-opacity-70 backdrop-blur-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-medical-blue to-trust-blue rounded-2xl flex items-center justify-center mr-4 shadow-soft">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-warm-gray-900">{{ __('messages.contact.hours_title') }}</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-white bg-opacity-60 rounded-xl">
                            <span class="text-warm-gray-700 font-medium">{{ __('messages.opening_hours.monday_friday') }}</span>
                            <span class="font-bold text-trust-blue">{{ __('messages.opening_hours.time_mf') }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-white bg-opacity-60 rounded-xl">
                            <span class="text-warm-gray-700 font-medium">{{ __('messages.opening_hours.saturday') }}</span>
                            <span class="font-bold text-trust-blue">{{ __('messages.opening_hours.time_sat') }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-white bg-opacity-40 rounded-xl">
                            <span class="text-warm-gray-600">{{ __('messages.opening_hours.sunday') }}</span>
                            <span class="text-warm-gray-500 italic">{{ __('messages.opening_hours.closed') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div id="contact-form">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">{{ __('messages.contact.form_title') }}</h2>
                
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg" role="alert" aria-live="polite">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg" role="alert" aria-live="assertive">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <p class="text-gray-600 mb-6">{{ __('messages.contact.form_subtitle') }}</p>

                <form action="{{ route('form.submit') }}" method="POST" class="space-y-6" novalidate aria-describedby="form-instructions" id="contact-form-element"
                      data-validation-field-required="{{ __('messages.validation.field_required') }}"
                      data-validation-invalid-name="{{ __('messages.validation.invalid_name') }}"
                      data-validation-invalid-email="{{ __('messages.validation.invalid_email') }}"
                      data-validation-invalid-phone="{{ __('messages.validation.invalid_phone') }}"
                      data-validation-invalid-date="{{ __('messages.validation.invalid_date') }}"
                      data-validation-message-too-long="{{ __('messages.validation.message_too_long') }}"
                      data-validation-select-reason="{{ __('messages.validation.select_reason') }}"
                      data-validation-min-length="{{ __('messages.validation.min_length') }}">
                    <div id="form-instructions" class="sr-only">
                        {{ __('messages.contact.form_subtitle') }}. Pflichtfelder sind mit einem Sternchen (*) markiert.
                    </div>
                    
                    <!-- Progress indicator -->
                    <div class="bg-warm-gray-100 rounded-full h-2 mb-6 overflow-hidden" role="progressbar" aria-label="Formular Fortschritt" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                        <div id="form-progress" class="bg-gradient-to-r from-medical-blue to-trust-blue h-full w-0 transition-all duration-500 ease-out"></div>
                    </div>
                    
                    @csrf

                    <!-- Reason for Contact (Moved to first position) -->
                    <div>
                        <label for="contact_reason_id" class="block text-sm font-semibold text-warm-gray-700 mb-2">
                            {{ __('messages.contact.reason') }} <span class="text-red-500" aria-label="Pflichtfeld">*</span>
                        </label>
                        <div class="relative">
                            <select id="contact_reason_id" 
                                    name="contact_reason_id" 
                                    required
                                    aria-required="true"
                                    aria-describedby="@error('contact_reason_id') contact_reason_error @enderror contact_reason_help"
                                    class="w-full px-6 py-5 border-2 border-warm-gray-200 rounded-3xl focus:ring-4 focus:ring-medical-blue focus:ring-opacity-20 focus:border-medical-blue transition-all duration-500 shadow-gentle hover:shadow-card bg-white bg-opacity-90 backdrop-blur-sm @error('contact_reason_id') border-red-500 aria-invalid @enderror">
                                <option value="">{{ __('messages.contact.reason_placeholder') }}</option>
                                @foreach(\App\Models\ContactReason::getOptionsArray() as $id => $label)
                                    <option value="{{ $id }}" {{ old('contact_reason_id') == $id ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none" aria-hidden="true">
                                <svg class="w-5 h-5 text-warm-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                </svg>
                            </div>
                        </div>
                        <div id="contact_reason_help" class="sr-only">Wählen Sie den Grund für Ihre Kontaktaufnahme aus</div>
                        @error('contact_reason_id')
                            <p id="contact_reason_error" class="mt-2 text-sm text-red-600 flex items-center" role="alert">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Full Name -->
                    <div class="group">
                        <label for="full_name" class="block text-sm font-semibold text-warm-gray-700 mb-2">
                            {{ __('messages.contact.full_name') }} <span class="text-red-500" aria-label="Pflichtfeld">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="full_name" 
                                   name="full_name" 
                                   value="{{ old('full_name') }}"
                                   required
                                   aria-required="true"
                                   aria-describedby="@error('full_name') full_name_error @enderror full_name_help"
                                   autocomplete="name"
                                   class="w-full px-6 py-5 border-2 border-warm-gray-200 rounded-3xl focus:ring-4 focus:ring-medical-blue focus:ring-opacity-20 focus:border-medical-blue transition-all duration-500 shadow-gentle hover:shadow-card bg-white bg-opacity-90 backdrop-blur-sm @error('full_name') border-red-500 aria-invalid @enderror">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 opacity-0 group-focus-within:opacity-100 transition-opacity" aria-hidden="true">
                                <svg class="w-5 h-5 text-medical-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div id="full_name_help" class="sr-only">Geben Sie Ihren vollständigen Namen ein</div>
                        @error('full_name')
                            <p id="full_name_error" class="mt-2 text-sm text-red-600 flex items-center" role="alert">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-warm-gray-700 mb-2">
                            {{ __('messages.contact.email') }} <span class="text-red-500" aria-label="Pflichtfeld">*</span>
                        </label>
                        <div class="relative">
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required
                                   aria-required="true"
                                   aria-describedby="@error('email') email_error @enderror email_help"
                                   autocomplete="email"
                                   placeholder="beispiel@email.de"
                                   class="w-full px-6 py-5 border-2 border-warm-gray-200 rounded-3xl focus:ring-4 focus:ring-medical-blue focus:ring-opacity-20 focus:border-medical-blue transition-all duration-500 shadow-gentle hover:shadow-card bg-white bg-opacity-90 backdrop-blur-sm @error('email') border-red-500 aria-invalid @enderror">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 opacity-0 group-focus-within:opacity-100 transition-opacity" aria-hidden="true">
                                <svg class="w-5 h-5 text-medical-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div id="email_help" class="sr-only">Geben Sie eine gültige E-Mail-Adresse ein</div>
                        @error('email')
                            <p id="email_error" class="mt-2 text-sm text-red-600 flex items-center" role="alert">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.contact.phone') }} <span class="text-gray-500 text-sm">({{ __('messages.contact.optional') }})</span>
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               aria-describedby="@error('phone') phone_error @enderror phone_help"
                               autocomplete="tel"
                               placeholder="+49 123 456789"
                               class="w-full px-6 py-5 border-2 border-warm-gray-200 rounded-3xl focus:ring-4 focus:ring-medical-blue focus:ring-opacity-20 focus:border-medical-blue transition-all duration-500 shadow-gentle hover:shadow-card bg-white bg-opacity-90 backdrop-blur-sm @error('phone') border-red-500 aria-invalid @enderror">
                        <div id="phone_help" class="sr-only">Optionale Telefonnummer für Rückfragen</div>
                        @error('phone')
                            <p id="phone_error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Preferred DateTime -->
                    <div>
                        <label for="preferred_datetime" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.contact.preferred_datetime') }} <span class="text-gray-500 text-sm">({{ __('messages.contact.optional') }})</span>
                        </label>
                        <input type="datetime-local" 
                               id="preferred_datetime" 
                               name="preferred_datetime" 
                               value="{{ old('preferred_datetime') }}"
                               min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                               aria-describedby="@error('preferred_datetime') datetime_error @enderror datetime_help"
                               class="w-full px-6 py-5 border-2 border-warm-gray-200 rounded-3xl focus:ring-4 focus:ring-medical-blue focus:ring-opacity-20 focus:border-medical-blue transition-all duration-500 shadow-gentle hover:shadow-card bg-white bg-opacity-90 backdrop-blur-sm @error('preferred_datetime') border-red-500 aria-invalid @enderror">
                        <div id="datetime_help" class="sr-only">Wählen Sie Ihren Wunschtermin aus (optional)</div>
                        @error('preferred_datetime')
                            <p id="datetime_error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.contact.message') }} <span class="text-gray-500 text-sm">({{ __('messages.contact.optional') }})</span>
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="4"
                                  aria-describedby="@error('message') message_error @enderror message_help"
                                  class="w-full px-6 py-5 border-2 border-warm-gray-200 rounded-3xl focus:ring-4 focus:ring-medical-blue focus:ring-opacity-20 focus:border-medical-blue transition-all duration-500 shadow-gentle hover:shadow-card bg-white bg-opacity-90 backdrop-blur-sm @error('message') border-red-500 aria-invalid @enderror"
                                  placeholder="{{ __('messages.contact.message_placeholder') }}">{{ old('message') }}</textarea>
                        <div id="message_help" class="sr-only">Zusätzliche Nachricht oder Anmerkungen (optional)</div>
                        @error('message')
                            <p id="message_error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            id="submit-button"
                            class="group w-full bg-gradient-to-r from-medical-blue to-trust-blue text-white py-6 px-10 rounded-3xl font-bold text-lg hover:shadow-floating focus:ring-4 focus:ring-white focus:ring-opacity-80 transform hover:-translate-y-1 transition-all duration-600 ease-out flex items-center justify-center focus:outline-none shadow-card"
                            aria-describedby="submit-help">
                        <span id="submit-text" class="mr-3">{{ __('messages.contact.submit') }}</span>
                        
                        <!-- Default arrow icon -->
                        <svg id="submit-arrow" class="w-6 h-6 group-hover:translate-x-1 transition-transform duration-400 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        
                        <!-- Loading spinner (hidden by default) -->
                        <svg id="submit-spinner" class="hidden w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        
                        <!-- Success checkmark (hidden by default) -->
                        <svg id="submit-success" class="hidden w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </button>

                    <div id="submit-help" class="text-sm text-gray-600">
                        <span class="text-red-500" aria-label="Pflichtfeld">*</span> {{ __('messages.contact.required') }}
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Transportation Map Section -->
@include('components.transportation-map')

<script>
/**
 * Enhanced Contact Form with Real-time Validation and UX Improvements
 * Medical practice optimized with accessibility and loading states
 */
class MedicalContactForm {
    constructor() {
        this.form = document.getElementById('contact-form-element');
        this.submitButton = document.getElementById('submit-button');
        this.submitText = document.getElementById('submit-text');
        this.submitArrow = document.getElementById('submit-arrow');
        this.submitSpinner = document.getElementById('submit-spinner');
        this.submitSuccess = document.getElementById('submit-success');
        this.progressBar = document.getElementById('form-progress');
        this.progressContainer = this.progressBar?.parentElement;
        this.liveRegion = document.getElementById('live-region');
        
        this.isSubmitting = false;
        this.validationRules = this.setupValidationRules();
        this.fieldStates = new Map();
        
        this.init();
    }
    
    init() {
        if (!this.form) return;
        
        this.setupFormValidation();
        this.setupProgressTracking();
        this.setupSubmitHandler();
        this.setupAccessibility();
        this.calculateInitialProgress();
    }
    
    setupValidationRules() {
        // Get localized messages from form data attributes
        const fieldRequired = this.form.dataset.validationFieldRequired || 'This field is required';
        const invalidName = this.form.dataset.validationInvalidName || 'Please enter a valid name';
        const invalidEmail = this.form.dataset.validationInvalidEmail || 'Please enter a valid email address';
        const invalidPhone = this.form.dataset.validationInvalidPhone || 'Please enter a valid phone number';
        const invalidDate = this.form.dataset.validationInvalidDate || 'Please select a future date';
        const messageTooLong = this.form.dataset.validationMessageTooLong || 'Message is too long (maximum 1000 characters)';
        const selectReason = this.form.dataset.validationSelectReason || 'Please select a reason for contact';
        const minLengthTemplate = this.form.dataset.validationMinLength || 'At least {min} characters required';
        
        return {
            full_name: {
                required: true,
                minLength: 2,
                pattern: /^[a-zA-ZäöüÄÖÜß\s\-']+$/,
                message: invalidName,
                requiredMessage: fieldRequired,
                minLengthMessage: minLengthTemplate
            },
            email: {
                required: true,
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                message: invalidEmail,
                requiredMessage: fieldRequired
            },
            contact_reason_id: {
                required: true,
                message: selectReason,
                requiredMessage: fieldRequired
            },
            phone: {
                required: false,
                pattern: /^[\+]?[0-9\s\-\(\)]{10,}$/,
                message: invalidPhone
            },
            preferred_datetime: {
                required: false,
                validate: (value) => {
                    if (!value) return true;
                    const selectedDate = new Date(value);
                    const now = new Date();
                    return selectedDate > now;
                },
                message: invalidDate
            },
            message: {
                required: false,
                maxLength: 1000,
                message: messageTooLong
            }
        };
    }
    
    setupFormValidation() {
        const formFields = this.form.querySelectorAll('input, select, textarea');
        
        formFields.forEach(field => {
            // Real-time validation on blur
            field.addEventListener('blur', () => {
                this.validateField(field);
                this.updateProgress();
            });
            
            // Input validation for immediate feedback
            field.addEventListener('input', () => {
                // Clear errors on input
                this.clearFieldError(field);
                
                // Debounced validation for performance
                clearTimeout(field.validationTimeout);
                field.validationTimeout = setTimeout(() => {
                    this.validateField(field, false); // Silent validation
                    this.updateProgress();
                }, 500);
            });
            
            // Focus enhancement
            field.addEventListener('focus', () => {
                this.enhanceFieldFocus(field);
            });
        });
    }
    
    validateField(field, showErrors = true) {
        const fieldName = field.name;
        const value = field.value.trim();
        const rules = this.validationRules[fieldName];
        
        if (!rules) return true;
        
        let isValid = true;
        let errorMessage = '';
        
        // Required validation
        if (rules.required && !value) {
            isValid = false;
            errorMessage = rules.requiredMessage || rules.message || 'This field is required';
        }
        
        // Pattern validation
        else if (value && rules.pattern && !rules.pattern.test(value)) {
            isValid = false;
            errorMessage = rules.message;
        }
        
        // Length validation
        else if (value && rules.minLength && value.length < rules.minLength) {
            isValid = false;
            errorMessage = rules.minLengthMessage ? 
                rules.minLengthMessage.replace('{min}', rules.minLength) : 
                `At least ${rules.minLength} characters required`;
        }
        
        else if (value && rules.maxLength && value.length > rules.maxLength) {
            isValid = false;
            errorMessage = rules.message;
        }
        
        // Custom validation
        else if (value && rules.validate && !rules.validate(value)) {
            isValid = false;
            errorMessage = rules.message;
        }
        
        // Update field state
        this.fieldStates.set(fieldName, {
            isValid,
            hasValue: !!value,
            isRequired: rules.required
        });
        
        // Show/hide errors
        if (showErrors) {
            if (isValid) {
                this.showFieldSuccess(field);
            } else if (errorMessage) {
                this.showFieldError(field, errorMessage);
            }
        }
        
        return isValid;
    }
    
    showFieldError(field, message) {
        this.clearFieldError(field);
        
        // Add error styling
        field.classList.add('border-red-500', 'aria-invalid');
        field.setAttribute('aria-invalid', 'true');
        
        // Create error message
        const errorId = `${field.name}_validation_error`;
        const errorElement = document.createElement('p');
        errorElement.id = errorId;
        errorElement.className = 'mt-2 text-sm text-red-600 flex items-center';
        errorElement.setAttribute('role', 'alert');
        errorElement.innerHTML = `
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            ${message}
        `;
        
        // Insert error message
        field.parentNode.appendChild(errorElement);
        
        // Update aria-describedby
        const describedBy = field.getAttribute('aria-describedby') || '';
        field.setAttribute('aria-describedby', `${describedBy} ${errorId}`.trim());
    }
    
    showFieldSuccess(field) {
        this.clearFieldError(field);
        
        // Add success styling
        field.classList.remove('border-red-500', 'aria-invalid');
        field.classList.add('border-green-500');
        field.setAttribute('aria-invalid', 'false');
        
        // Add success icon to field
        const existingIcon = field.parentNode.querySelector('.validation-icon');
        if (!existingIcon) {
            const iconContainer = document.createElement('div');
            iconContainer.className = 'absolute inset-y-0 right-0 flex items-center pr-4 validation-icon';
            iconContainer.innerHTML = `
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            `;
            
            if (field.parentNode.style.position !== 'relative') {
                field.parentNode.style.position = 'relative';
            }
            field.parentNode.appendChild(iconContainer);
        }
    }
    
    clearFieldError(field) {
        // Remove error styling
        field.classList.remove('border-red-500', 'border-green-500', 'aria-invalid');
        
        // Remove error message
        const errorElement = field.parentNode.querySelector(`#${field.name}_validation_error`);
        if (errorElement) {
            errorElement.remove();
        }
        
        // Remove success icon
        const successIcon = field.parentNode.querySelector('.validation-icon');
        if (successIcon) {
            successIcon.remove();
        }
    }
    
    enhanceFieldFocus(field) {
        // Add subtle animation on focus
        field.style.transform = 'scale(1.01)';
        setTimeout(() => {
            field.style.transform = '';
        }, 150);
    }
    
    setupProgressTracking() {
        this.updateProgress();
    }
    
    updateProgress() {
        const totalFields = Object.keys(this.validationRules).length;
        const requiredFields = Object.values(this.validationRules).filter(rule => rule.required).length;
        
        let completedRequired = 0;
        let completedOptional = 0;
        
        this.fieldStates.forEach((state, fieldName) => {
            const rules = this.validationRules[fieldName];
            if (state.hasValue && state.isValid) {
                if (rules.required) {
                    completedRequired++;
                } else {
                    completedOptional++;
                }
            }
        });
        
        // Progress calculation: 70% for required fields, 30% for optional
        const requiredProgress = (completedRequired / requiredFields) * 70;
        const optionalProgress = (completedOptional / (totalFields - requiredFields)) * 30;
        const totalProgress = Math.min(requiredProgress + optionalProgress, 100);
        
        // Update progress bar
        if (this.progressBar) {
            this.progressBar.style.width = `${totalProgress}%`;
            this.progressContainer.setAttribute('aria-valuenow', Math.round(totalProgress));
        }
        
        // Update submit button state
        this.updateSubmitButton(completedRequired === requiredFields);
    }
    
    calculateInitialProgress() {
        // Check for pre-filled fields (old values)
        const formFields = this.form.querySelectorAll('input, select, textarea');
        formFields.forEach(field => {
            if (field.value.trim()) {
                this.validateField(field, false);
            }
        });
        this.updateProgress();
    }
    
    updateSubmitButton(canSubmit) {
        if (canSubmit) {
            this.submitButton.disabled = false;
            this.submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            this.submitButton.classList.add('hover:shadow-floating', 'hover:-translate-y-1');
        } else {
            this.submitButton.disabled = false; // Keep enabled for validation feedback
            this.submitButton.classList.add('opacity-75');
            this.submitButton.classList.remove('hover:shadow-floating', 'hover:-translate-y-1');
        }
    }
    
    setupSubmitHandler() {
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleSubmit();
        });
    }
    
    async handleSubmit() {
        if (this.isSubmitting) return;
        
        // Validate all fields
        const formFields = this.form.querySelectorAll('input, select, textarea');
        let isFormValid = true;
        
        formFields.forEach(field => {
            const isValid = this.validateField(field, true);
            if (!isValid) isFormValid = false;
        });
        
        if (!isFormValid) {
            this.announceToScreenReader('Das Formular enthält Fehler. Bitte überprüfen Sie Ihre Eingaben.');
            this.focusFirstError();
            return;
        }
        
        // Show loading state
        this.setSubmitState('loading');
        
        try {
            // Create FormData
            const formData = new FormData(this.form);
            
            // Submit form
            const response = await fetch(this.form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (response.ok) {
                this.setSubmitState('success');
                this.announceToScreenReader('Ihre Nachricht wurde erfolgreich gesendet!');
                
                // Redirect after showing success
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                throw new Error('Submission failed');
            }
            
        } catch (error) {
            this.setSubmitState('error');
            this.announceToScreenReader('Es ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.');
            console.error('Form submission error:', error);
        }
    }
    
    setSubmitState(state) {
        this.isSubmitting = state === 'loading';
        
        // Reset all icons
        this.submitArrow.classList.add('hidden');
        this.submitSpinner.classList.add('hidden');
        this.submitSuccess.classList.add('hidden');
        
        switch (state) {
            case 'loading':
                this.submitText.textContent = 'Wird gesendet...';
                this.submitSpinner.classList.remove('hidden');
                this.submitButton.disabled = true;
                this.submitButton.setAttribute('aria-busy', 'true');
                break;
                
            case 'success':
                this.submitText.textContent = 'Erfolgreich gesendet!';
                this.submitSuccess.classList.remove('hidden');
                this.submitButton.classList.add('bg-green-600');
                this.submitButton.setAttribute('aria-busy', 'false');
                break;
                
            case 'error':
                this.submitText.textContent = 'Fehler - Bitte erneut versuchen';
                this.submitArrow.classList.remove('hidden');
                this.submitButton.disabled = false;
                this.submitButton.classList.add('bg-red-600');
                this.submitButton.setAttribute('aria-busy', 'false');
                setTimeout(() => this.resetSubmitButton(), 3000);
                break;
                
            default:
                this.resetSubmitButton();
        }
    }
    
    resetSubmitButton() {
        this.submitText.textContent = 'Nachricht senden';
        this.submitArrow.classList.remove('hidden');
        this.submitSpinner.classList.add('hidden');
        this.submitSuccess.classList.add('hidden');
        this.submitButton.disabled = false;
        this.submitButton.classList.remove('bg-green-600', 'bg-red-600');
        this.submitButton.setAttribute('aria-busy', 'false');
        this.isSubmitting = false;
    }
    
    focusFirstError() {
        const firstError = this.form.querySelector('.border-red-500');
        if (firstError) {
            firstError.focus();
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
    
    setupAccessibility() {
        // Add live region announcements
        const requiredFields = this.form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            field.addEventListener('invalid', (e) => {
                e.preventDefault(); // Prevent default browser validation
                this.validateField(field, true);
            });
        });
    }
    
    announceToScreenReader(message) {
        if (this.liveRegion) {
            this.liveRegion.textContent = message;
        }
    }
    
    // Public API
    validateForm() {
        const formFields = this.form.querySelectorAll('input, select, textarea');
        let isValid = true;
        
        formFields.forEach(field => {
            if (!this.validateField(field, true)) {
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    resetForm() {
        this.form.reset();
        this.fieldStates.clear();
        
        // Clear all validation states
        const formFields = this.form.querySelectorAll('input, select, textarea');
        formFields.forEach(field => {
            this.clearFieldError(field);
        });
        
        this.updateProgress();
        this.resetSubmitButton();
    }
}

// Initialize contact form when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    window.medicalContactForm = new MedicalContactForm();
});

// Add enhanced styling for better UX
const style = document.createElement('style');
style.textContent = `
    /* Enhanced form field styling */
    .group input:focus, .group select:focus, .group textarea:focus {
        transform: scale(1.005);
        box-shadow: 0 8px 25px rgba(59, 123, 184, 0.1);
    }
    
    /* Progress bar animation */
    #form-progress {
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Submit button loading state */
    #submit-button:disabled {
        cursor: not-allowed;
    }
    
    /* Success/error states */
    .border-green-500 {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 1px #10b981;
    }
    
    .border-red-500 {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 1px #ef4444;
    }
    
    /* Validation icon positioning */
    .validation-icon {
        pointer-events: none;
        z-index: 10;
    }
    
    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        .group input, .group select, .group textarea {
            transform: none !important;
        }
        
        #form-progress {
            transition: none !important;
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection