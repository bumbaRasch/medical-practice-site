@extends('layouts.app')

@section('title', __('messages.team.page_title') . ' - ' . __('messages.common.practice_name'))
@section('description', __('messages.team.page_meta_description'))

@section('content')
<!-- Page Header -->
<section class="relative bg-gradient-to-br from-gentle-blue via-medical-light-blue to-gentle-mint py-20 overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 opacity-10">
        <svg class="absolute top-12 right-12 w-28 h-28 text-warm-green animate-pulse" fill="currentColor" viewBox="0 0 24 24">
            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 bg-white bg-opacity-90 rounded-full text-sm font-medium text-trust-blue mb-6 shadow-gentle">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                {{ __('messages.team.header_badge') }}
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-warm-gray-900 mb-6">
                {{ __('messages.team.page_title') }}
            </h1>
            <p class="text-xl text-warm-gray-700 max-w-3xl mx-auto leading-relaxed">
                {{ __('messages.team.page_subtitle') }}
            </p>
        </div>
    </div>
</section>

<!-- Team Introduction -->
<section class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-br from-gentle-blue to-medical-light-blue rounded-3xl p-12 shadow-soft">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-medical-blue to-trust-blue rounded-2xl mb-8">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            
            <h2 class="text-4xl font-bold text-warm-gray-900 mb-6">
                {{ __('messages.team.meet_team_title') }}
            </h2>
            <p class="text-xl text-warm-gray-700 mb-8 max-w-3xl mx-auto leading-relaxed">
                {{ __('messages.team.meet_team_text') }}
            </p>
            
            <div class="flex items-center justify-center space-x-8 text-sm text-warm-gray-600">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-warm-green mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                    </svg>
                    {{ __('messages.team.experience_years') }}
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-trust-blue mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                    </svg>
                    {{ __('messages.team.continuing_education') }}
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-warm-blue mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                    </svg>
                    {{ __('messages.team.personal_care') }}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Members -->
<section class="py-20 bg-gradient-to-br from-warm-gray-50 to-gentle-blue">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($team as $index => $member)
            <div class="group bg-white rounded-3xl overflow-hidden shadow-soft hover:shadow-warm transition-all duration-600 ease-out transform hover:-translate-y-1 flex flex-col h-full">
                <!-- Team Member Image -->
                <div class="relative">
                    @if($member['image'])
                        <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="w-full h-64 object-cover" style="object-position: center 10%">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-gentle-blue to-medical-light-blue flex items-center justify-center relative overflow-hidden">
                            <!-- Decorative circles -->
                            <div class="absolute top-4 right-4 w-12 h-12 bg-white bg-opacity-20 rounded-full"></div>
                            <div class="absolute bottom-6 left-6 w-8 h-8 bg-trust-blue bg-opacity-30 rounded-full"></div>
                            
                            <div class="w-24 h-24 bg-gradient-to-br from-medical-blue to-trust-blue rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Role Badge -->
                    <div class="absolute bottom-4 left-4 bg-white bg-opacity-95 backdrop-blur-sm px-4 py-2 rounded-full shadow-gentle">
                        <p class="text-sm font-bold text-trust-blue">
                            {{ $member['role'] }}
                        </p>
                    </div>
                </div>

                <!-- Team Member Info -->
                <div class="p-8 flex flex-col flex-grow">
                    <div class="flex items-center mb-4">
                        <h3 class="text-2xl font-bold text-warm-gray-900 group-hover:text-medical-blue transition-colors">
                            {{ $member['name'] }}
                        </h3>
                        <div class="ml-auto w-8 h-8 bg-gradient-to-br from-warm-green to-soft-green rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <p class="text-warm-gray-600 leading-relaxed mb-6 flex-grow">
                        {{ $member['bio'] }}
                    </p>
                    
                    <!-- Experience Indicators -->
                    <div class="flex items-center space-x-4 text-xs text-warm-gray-500 mt-auto">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-warm-green rounded-full mr-2"></div>
                            {{ __('messages.team.qualities.experienced') }}
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-trust-blue rounded-full mr-2"></div>
                            {{ __('messages.team.qualities.empathetic') }}
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-soft-blue rounded-full mr-2"></div>
                            {{ __('messages.team.qualities.competent') }}
                        </div>
                    </div>
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
        <svg class="absolute top-16 left-16 w-40 h-40 text-trust-blue" fill="currentColor" viewBox="0 0 24 24">
            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
        <svg class="absolute bottom-16 right-16 w-32 h-32 text-warm-green" fill="currentColor" viewBox="0 0 24 24">
            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
    </div>
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <div class="bg-white bg-opacity-90 backdrop-blur-sm rounded-3xl p-12 shadow-warm">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-medical-blue to-trust-blue rounded-2xl mb-8">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            
            <h2 class="text-4xl font-bold text-warm-gray-900 mb-6">
                {{ __('messages.team.cta_title') }}
            </h2>
            <p class="text-xl text-warm-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed">
                {{ __('messages.team.cta_description') }}
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('contact') }}" 
                   class="group bg-gradient-to-r from-medical-blue-dark to-trust-blue text-white px-10 py-4 rounded-2xl font-bold text-lg hover:shadow-warm transform hover:-translate-y-1 transition-all duration-500 ease-out flex items-center justify-center focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-80">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('messages.nav.book_appointment') }}
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-400 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                
                <a href="{{ route('services') }}" 
                   class="group bg-white border-2 border-trust-blue text-trust-blue px-10 py-4 rounded-2xl font-bold text-lg hover:bg-trust-blue hover:text-white transition-all duration-500 ease-out flex items-center justify-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('messages.team.services_link') }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection