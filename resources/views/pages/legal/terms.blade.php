@extends('layouts.app')

@section('title', $title . ' - ' . __('messages.common.practice_name'))
@section('description', $meta_description)

@section('content')
<!-- Terms of Service Page -->
<section class="bg-medical-light-blue py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                {{ __('messages.legal.terms.title') }}
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ __('messages.legal.terms.subtitle') }}
            </p>
        </div>
    </div>
</section>

<!-- Terms Content -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg max-w-none">
            
            <!-- Scope -->
            <h2>{{ __('messages.legal.terms.scope.title') }}</h2>
            <p>{{ __('messages.legal.terms.scope.description') }}</p>

            <!-- Appointment Booking -->
            <h2>{{ __('messages.legal.terms.appointments.title') }}</h2>
            <h3>{{ __('messages.legal.terms.appointments.booking.title') }}</h3>
            <p>{{ __('messages.legal.terms.appointments.booking.description') }}</p>
            <ul>
                <li>{{ __('messages.legal.terms.appointments.booking.online') }}</li>
                <li>{{ __('messages.legal.terms.appointments.booking.phone') }}</li>
                <li>{{ __('messages.legal.terms.appointments.booking.person') }}</li>
            </ul>

            <h3>{{ __('messages.legal.terms.appointments.confirmation.title') }}</h3>
            <p>{{ __('messages.legal.terms.appointments.confirmation.description') }}</p>

            <!-- Cancellations and Changes -->
            <h2>{{ __('messages.legal.terms.cancellation.title') }}</h2>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-6">
                <p class="font-semibold text-yellow-800">{{ __('messages.legal.terms.cancellation.notice.title') }}</p>
                <p class="text-yellow-700">{{ __('messages.legal.terms.cancellation.notice.description') }}</p>
            </div>
            
            <h3>{{ __('messages.legal.terms.cancellation.patient.title') }}</h3>
            <p>{{ __('messages.legal.terms.cancellation.patient.description') }}</p>
            
            <h3>{{ __('messages.legal.terms.cancellation.practice.title') }}</h3>
            <p>{{ __('messages.legal.terms.cancellation.practice.description') }}</p>

            <h3>{{ __('messages.legal.terms.cancellation.no_show.title') }}</h3>
            <p>{{ __('messages.legal.terms.cancellation.no_show.description') }}</p>

            <!-- Patient Obligations -->
            <h2>{{ __('messages.legal.terms.patient_obligations.title') }}</h2>
            <ul>
                <li>{{ __('messages.legal.terms.patient_obligations.punctuality') }}</li>
                <li>{{ __('messages.legal.terms.patient_obligations.insurance') }}</li>
                <li>{{ __('messages.legal.terms.patient_obligations.information') }}</li>
                <li>{{ __('messages.legal.terms.patient_obligations.medication') }}</li>
                <li>{{ __('messages.legal.terms.patient_obligations.respect') }}</li>
            </ul>

            <!-- Practice Obligations -->
            <h2>{{ __('messages.legal.terms.practice_obligations.title') }}</h2>
            <ul>
                <li>{{ __('messages.legal.terms.practice_obligations.care') }}</li>
                <li>{{ __('messages.legal.terms.practice_obligations.confidentiality') }}</li>
                <li>{{ __('messages.legal.terms.practice_obligations.standards') }}</li>
                <li>{{ __('messages.legal.terms.practice_obligations.information') }}</li>
                <li>{{ __('messages.legal.terms.practice_obligations.emergency') }}</li>
            </ul>

            <!-- Waiting Times -->
            <h2>{{ __('messages.legal.terms.waiting_times.title') }}</h2>
            <p>{{ __('messages.legal.terms.waiting_times.description') }}</p>
            <div class="bg-medical-light-blue p-6 rounded-lg mb-6">
                <p class="font-semibold">{{ __('messages.legal.terms.waiting_times.emergency.title') }}</p>
                <p>{{ __('messages.legal.terms.waiting_times.emergency.description') }}</p>
            </div>

            <!-- Liability -->
            <h2>{{ __('messages.legal.terms.liability.title') }}</h2>
            <h3>{{ __('messages.legal.terms.liability.practice.title') }}</h3>
            <p>{{ __('messages.legal.terms.liability.practice.description') }}</p>
            
            <h3>{{ __('messages.legal.terms.liability.patient.title') }}</h3>
            <p>{{ __('messages.legal.terms.liability.patient.description') }}</p>

            <h3>{{ __('messages.legal.terms.liability.limitation.title') }}</h3>
            <p>{{ __('messages.legal.terms.liability.limitation.description') }}</p>

            <!-- Data Protection Reference -->
            <h2>{{ __('messages.legal.terms.data_protection.title') }}</h2>
            <p>{{ __('messages.legal.terms.data_protection.description') }} 
               <a href="{{ route('legal.privacy') }}" class="text-medical-blue underline">{{ __('messages.legal.terms.data_protection.link_text') }}</a>.
            </p>

            <!-- Applicable Law -->
            <h2>{{ __('messages.legal.terms.applicable_law.title') }}</h2>
            <p>{{ __('messages.legal.terms.applicable_law.description') }}</p>

            <!-- Dispute Resolution -->
            <h2>{{ __('messages.legal.terms.dispute_resolution.title') }}</h2>
            <p>{{ __('messages.legal.terms.dispute_resolution.description') }}</p>

            <!-- Severability -->
            <h2>{{ __('messages.legal.terms.severability.title') }}</h2>
            <p>{{ __('messages.legal.terms.severability.description') }}</p>

            <!-- Changes to Terms -->
            <h2>{{ __('messages.legal.terms.changes.title') }}</h2>
            <p>{{ __('messages.legal.terms.changes.description') }}</p>

            <!-- Emergency Information -->
            <div class="bg-red-50 border-l-4 border-red-400 p-6 mt-8">
                <h3 class="font-semibold text-red-800 mb-2">{{ __('messages.legal.terms.emergency_info.title') }}</h3>
                <p class="text-red-700 mb-2">{{ __('messages.legal.terms.emergency_info.description') }}</p>
                <p class="text-red-700 font-semibold">{{ __('messages.legal.terms.emergency_info.number') }}: {{ __('messages.home.emergency_number') }}</p>
            </div>

            <!-- Last Updated -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    {{ __('messages.legal.terms.last_updated') }}: {{ __('messages.legal.terms.last_updated_date') }}
                </p>
            </div>
        </div>
    </div>
</section>
@endsection