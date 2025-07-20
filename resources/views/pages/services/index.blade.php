@extends('layouts.app')

@section('title', __('messages.services.page_title') . ' - ' . __('messages.common.practice_name'))
@section('description', __('messages.services.page_meta_description'))

@section('content')
<!-- Services Slideshow -->
@include('components.services-slideshow')

<!-- Page Header -->
<section class="relative bg-gradient-to-br from-gentle-blue via-medical-light-blue to-gentle-mint py-20 overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 opacity-10">
        <svg class="absolute top-16 left-16 w-20 h-20 text-warm-green animate-pulse" fill="currentColor" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <svg class="absolute bottom-16 right-12 w-16 h-16 text-trust-blue animate-pulse delay-1000" fill="currentColor" viewBox="0 0 24 24">
            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 bg-white bg-opacity-90 rounded-full text-sm font-medium text-trust-blue mb-6 shadow-gentle">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('messages.services.page_header_badge') }}
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-warm-gray-900 mb-6">
                {{ __('messages.services.page_title') }}
            </h1>
            <p class="text-xl text-warm-gray-700 max-w-3xl mx-auto leading-relaxed">
                {{ __('messages.services.page_subtitle') }}
            </p>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-20 bg-gradient-to-br from-warm-gray-50 to-gentle-blue">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-warm-gray-900 mb-4">
                {{ __('messages.services.grid_title') }}
            </h2>
            <p class="text-lg text-warm-gray-600 max-w-2xl mx-auto">
                {{ __('messages.services.grid_subtitle') }}
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $index => $service)
            <div class="group bg-white rounded-2xl p-8 shadow-soft hover:shadow-warm transition-all duration-700 ease-out transform hover:-translate-y-2 border border-white border-opacity-50 flex flex-col h-full">
                <!-- Service Icon -->
                <div class="relative mb-6">
                    @php
                        $gradientColors = [
                            'from-medical-blue to-trust-blue',
                            'from-warm-green to-soft-green', 
                            'from-trust-blue to-soft-blue',
                            'from-warm-blue to-medical-blue',
                            'from-soft-green to-warm-green',
                            'from-soft-blue to-trust-blue'
                        ];
                        $gradientClass = $gradientColors[$index % count($gradientColors)];
                    @endphp
                    <div class="w-16 h-16 bg-gradient-to-br {{ $gradientClass }} rounded-2xl flex items-center justify-center group-hover:scale-105 group-hover:rotate-2 transition-transform duration-600 ease-out">
                        @include('components._service-icon', ['icon' => $service['icon']])
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-warm-green rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 ease-out"></div>
                </div>

                <!-- Service Content -->
                <h3 class="text-xl font-bold text-warm-gray-900 mb-4 group-hover:text-medical-blue transition-colors">
                    {{ __($service['title']) }}
                </h3>
                <p class="text-warm-gray-600 leading-relaxed flex-grow">
                    {{ __($service['description']) }}
                </p>
                
                <!-- Service Badge -->
                @php
                    // Show "Verfügbar" badge on selected services (e.g., every other service starting with first)
                    $showAvailable = in_array($index, [0, 2, 4]); // Show on 1st, 3rd, 5th services
                @endphp
                
                <div class="mt-auto pt-6">
                    @if($showAvailable)
                        <div class="inline-flex items-center px-3 py-1 bg-gentle-blue rounded-full text-xs font-medium text-trust-blue border border-trust-blue border-opacity-20">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                            </svg>
                            {{ __('messages.services.availability_available') }}
                        </div>
                    @else
                        @php
                            // Use different text for home visits (index 5) vs other appointment services
                            $availabilityText = ($index === 5) ? 'availability_consultation' : 'availability_appointment';
                        @endphp
                        <div class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-warm-gray-100 to-warm-gray-200 rounded-full text-xs font-medium text-warm-gray-600">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('messages.services.' . $availabilityText) }}
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-br from-medical-light-blue to-gentle-mint relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <svg class="absolute top-10 left-10 w-32 h-32 text-medical-blue" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
        </svg>
        <svg class="absolute bottom-10 right-10 w-24 h-24 text-warm-green" fill="currentColor" viewBox="0 0 24 24">
            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <div class="bg-white bg-opacity-80 backdrop-blur-sm rounded-3xl p-12 shadow-warm">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-medical-blue to-trust-blue rounded-2xl mb-8">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h2 class="text-4xl font-bold text-warm-gray-900 mb-6">
                {{ __('messages.services.questions_title') }}
            </h2>
            <p class="text-xl text-warm-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed">
                {{ __('messages.services.questions_subtitle') }}
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('contact') }}" 
                   class="group bg-gradient-to-r from-medical-blue-dark to-trust-blue text-white px-10 py-4 rounded-2xl font-bold text-lg hover:shadow-warm transform hover:-translate-y-1 transition-all duration-500 ease-out flex items-center justify-center focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-80">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('messages.services.consultation_cta') }}
                </a>
                
                <a href="tel:{{ __('messages.common.phone_number') }}" 
                   class="group bg-white border-2 border-trust-blue text-trust-blue px-10 py-4 rounded-2xl font-bold text-lg hover:bg-trust-blue hover:text-white transition-all duration-500 ease-out flex items-center justify-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    {{ __('messages.services.call_now') }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@vite(['resources/js/services-slideshow.js'])
@endpush