@extends('layouts.app')

@section('title', $title . ' - ' . __('messages.common.practice_name'))
@section('description', $meta_description)

@section('content')
<!-- Privacy Policy Page -->
<section class="bg-medical-light-blue py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                {{ __('messages.legal.privacy.title') }}
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ __('messages.legal.privacy.subtitle') }}
            </p>
        </div>
    </div>
</section>

<!-- Privacy Policy Content -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg max-w-none">
            
            <!-- Data Controller -->
            <h2>{{ __('messages.legal.privacy.controller.title') }}</h2>
            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <p><strong>{{ __('messages.legal.privacy.controller.practice_name') }}</strong></p>
                <p>{{ __('messages.common.address') }}</p>
                <p>{{ __('messages.legal.privacy.controller.phone') }}: {{ __('messages.common.phone_number') }}</p>
                <p>{{ __('messages.legal.privacy.controller.email') }}: {{ __('messages.common.email_address') }}</p>
            </div>

            <!-- Data Processing -->
            <h2>{{ __('messages.legal.privacy.processing.title') }}</h2>
            <p>{{ __('messages.legal.privacy.processing.intro') }}</p>
            
            <h3>{{ __('messages.legal.privacy.processing.contact_form.title') }}</h3>
            <p>{{ __('messages.legal.privacy.processing.contact_form.description') }}</p>
            <ul>
                <li>{{ __('messages.legal.privacy.processing.contact_form.data.name') }}</li>
                <li>{{ __('messages.legal.privacy.processing.contact_form.data.email') }}</li>
                <li>{{ __('messages.legal.privacy.processing.contact_form.data.phone') }}</li>
                <li>{{ __('messages.legal.privacy.processing.contact_form.data.message') }}</li>
                <li>{{ __('messages.legal.privacy.processing.contact_form.data.appointment_time') }}</li>
            </ul>
            <p>{{ __('messages.legal.privacy.processing.contact_form.legal_basis') }}</p>

            <!-- Patient Rights -->
            <h2>{{ __('messages.legal.privacy.rights.title') }}</h2>
            <p>{{ __('messages.legal.privacy.rights.intro') }}</p>
            <ul>
                <li><strong>{{ __('messages.legal.privacy.rights.access.title') }}</strong>: {{ __('messages.legal.privacy.rights.access.description') }}</li>
                <li><strong>{{ __('messages.legal.privacy.rights.rectification.title') }}</strong>: {{ __('messages.legal.privacy.rights.rectification.description') }}</li>
                <li><strong>{{ __('messages.legal.privacy.rights.erasure.title') }}</strong>: {{ __('messages.legal.privacy.rights.erasure.description') }}</li>
                <li><strong>{{ __('messages.legal.privacy.rights.portability.title') }}</strong>: {{ __('messages.legal.privacy.rights.portability.description') }}</li>
                <li><strong>{{ __('messages.legal.privacy.rights.objection.title') }}</strong>: {{ __('messages.legal.privacy.rights.objection.description') }}</li>
            </ul>

            <!-- Storage Duration -->
            <h2>{{ __('messages.legal.privacy.storage.title') }}</h2>
            <p>{{ __('messages.legal.privacy.storage.description') }}</p>

            <!-- Medical Confidentiality -->
            <h2>{{ __('messages.legal.privacy.confidentiality.title') }}</h2>
            <p>{{ __('messages.legal.privacy.confidentiality.description') }}</p>

            <!-- Third Party Sharing -->
            <h2>{{ __('messages.legal.privacy.third_party.title') }}</h2>
            <p>{{ __('messages.legal.privacy.third_party.description') }}</p>

            <!-- Security -->
            <h2>{{ __('messages.legal.privacy.security.title') }}</h2>
            <p>{{ __('messages.legal.privacy.security.description') }}</p>

            <!-- Contact -->
            <h2>{{ __('messages.legal.privacy.contact.title') }}</h2>
            <p>{{ __('messages.legal.privacy.contact.description') }}</p>
            <div class="bg-medical-light-blue p-6 rounded-lg">
                <p><strong>{{ __('messages.legal.privacy.contact.email') }}:</strong> {{ __('messages.common.email_address') }}</p>
                <p><strong>{{ __('messages.legal.privacy.contact.phone') }}:</strong> {{ __('messages.common.phone_number') }}</p>
            </div>

            <!-- Last Updated -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    {{ __('messages.legal.privacy.last_updated') }}: {{ __('messages.legal.privacy.last_updated_date') }}
                </p>
            </div>
        </div>
    </div>
</section>
@endsection