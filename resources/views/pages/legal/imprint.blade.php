@extends('layouts.app')

@section('title', $title . ' - ' . __('messages.common.practice_name'))
@section('description', $meta_description)

@section('content')
<!-- Imprint Page -->
<section class="bg-medical-light-blue py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                {{ __('messages.legal.imprint.title') }}
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ __('messages.legal.imprint.subtitle') }}
            </p>
        </div>
    </div>
</section>

<!-- Imprint Content -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg max-w-none">
            
            <!-- Practice Information -->
            <h2>{{ __('messages.legal.imprint.practice_info.title') }}</h2>
            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <p><strong>{{ __('messages.legal.imprint.practice_info.name') }}</strong></p>
                <p>{{ __('messages.legal.imprint.practice_info.owner') }}</p>
                <p>{{ __('messages.common.address') }}</p>
                <br>
                <p><strong>{{ __('messages.legal.imprint.practice_info.phone') }}:</strong> {{ __('messages.common.phone_number') }}</p>
                <p><strong>{{ __('messages.legal.imprint.practice_info.email') }}:</strong> {{ __('messages.common.email_address') }}</p>
            </div>

            <!-- Professional Information -->
            <h2>{{ __('messages.legal.imprint.professional.title') }}</h2>
            <p><strong>{{ __('messages.legal.imprint.professional.designation') }}:</strong> {{ __('messages.legal.imprint.professional.designation_value') }}</p>
            <p><strong>{{ __('messages.legal.imprint.professional.state') }}:</strong> {{ __('messages.legal.imprint.professional.state_value') }}</p>
            <p><strong>{{ __('messages.legal.imprint.professional.license') }}:</strong> {{ __('messages.legal.imprint.professional.license_value') }}</p>

            <!-- Supervisory Authority -->
            <h2>{{ __('messages.legal.imprint.authority.title') }}</h2>
            <div class="bg-medical-light-blue p-6 rounded-lg mb-8">
                <p><strong>{{ __('messages.legal.imprint.authority.name') }}</strong></p>
                <p>{{ __('messages.legal.imprint.authority.address') }}</p>
                <p><strong>{{ __('messages.legal.imprint.authority.website') }}:</strong> <a href="{{ __('messages.legal.imprint.authority.website_url') }}" class="text-medical-blue underline" target="_blank" rel="noopener">{{ __('messages.legal.imprint.authority.website_url') }}</a></p>
            </div>

            <!-- Professional Regulations -->
            <h2>{{ __('messages.legal.imprint.regulations.title') }}</h2>
            <p>{{ __('messages.legal.imprint.regulations.description') }}</p>
            <ul>
                <li><a href="{{ __('messages.legal.imprint.regulations.bo_url') }}" class="text-medical-blue underline" target="_blank" rel="noopener">{{ __('messages.legal.imprint.regulations.bo_title') }}</a></li>
                <li><a href="{{ __('messages.legal.imprint.regulations.gebgo_url') }}" class="text-medical-blue underline" target="_blank" rel="noopener">{{ __('messages.legal.imprint.regulations.gebgo_title') }}</a></li>
                <li><a href="{{ __('messages.legal.imprint.regulations.mbo_url') }}" class="text-medical-blue underline" target="_blank" rel="noopener">{{ __('messages.legal.imprint.regulations.mbo_title') }}</a></li>
            </ul>

            <!-- Professional Liability Insurance -->
            <h2>{{ __('messages.legal.imprint.insurance.title') }}</h2>
            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <p><strong>{{ __('messages.legal.imprint.insurance.company') }}:</strong> {{ __('messages.legal.imprint.insurance.company_value') }}</p>
                <p><strong>{{ __('messages.legal.imprint.insurance.address') }}:</strong> {{ __('messages.legal.imprint.insurance.address_value') }}</p>
                <p><strong>{{ __('messages.legal.imprint.insurance.coverage') }}:</strong> {{ __('messages.legal.imprint.insurance.coverage_value') }}</p>
            </div>

            <!-- Dispute Resolution -->
            <h2>{{ __('messages.legal.imprint.dispute.title') }}</h2>
            <p>{{ __('messages.legal.imprint.dispute.description') }}</p>
            <div class="bg-medical-light-blue p-6 rounded-lg mb-8">
                <p><strong>{{ __('messages.legal.imprint.dispute.board_name') }}</strong></p>
                <p>{{ __('messages.legal.imprint.dispute.board_address') }}</p>
                <p><strong>{{ __('messages.legal.imprint.dispute.website') }}:</strong> <a href="{{ __('messages.legal.imprint.dispute.website_url') }}" class="text-medical-blue underline" target="_blank" rel="noopener">{{ __('messages.legal.imprint.dispute.website_url') }}</a></p>
            </div>

            <!-- Online Dispute Resolution (EU) -->
            <h2>{{ __('messages.legal.imprint.eu_dispute.title') }}</h2>
            <p>{{ __('messages.legal.imprint.eu_dispute.description') }}</p>
            <p><a href="{{ __('messages.legal.imprint.eu_dispute.platform_url') }}" class="text-medical-blue underline" target="_blank" rel="noopener">{{ __('messages.legal.imprint.eu_dispute.platform_url') }}</a></p>

            <!-- Copyright -->
            <h2>{{ __('messages.legal.imprint.copyright.title') }}</h2>
            <p>{{ __('messages.legal.imprint.copyright.description') }}</p>

            <!-- Disclaimer -->
            <h2>{{ __('messages.legal.imprint.disclaimer.title') }}</h2>
            <p>{{ __('messages.legal.imprint.disclaimer.content') }}</p>
            <p>{{ __('messages.legal.imprint.disclaimer.links') }}</p>

            <!-- Last Updated -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    {{ __('messages.legal.imprint.last_updated') }}: {{ __('messages.legal.imprint.last_updated_date') }}
                </p>
            </div>
        </div>
    </div>
</section>
@endsection