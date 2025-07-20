@component('mail::message')
# {{ __('messages.email.new_request_title') }}

{{ __('messages.email.new_request_intro') }}

## {{ __('messages.email.patient_data') }}

**{{ __('messages.email.name_label') }}:** {{ $contactData->fullName }}  
**{{ __('messages.email.email_label') }}:** {{ $contactData->email }}  
**{{ __('messages.email.reason_label') }}:** {{ $contactData->contactReason->getLocalizedName() }}  
@if($contactData->hasPhone())
**{{ __('messages.email.phone_label') }}:** {{ $contactData->phone }}  
@endif

@if($contactData->hasPreferredDatetime())
**{{ __('messages.email.preferred_time_label') }}:** {{ $contactData->getFormattedPreferredDatetime() }}  
@endif

@if($contactData->hasMessage())
## {{ __('messages.email.message_label') }}

{{ $contactData->message }}
@endif

---

**{{ __('messages.email.request_id_label') }}:** {{ $formRequest->id }}  
**{{ __('messages.email.submitted_at_label') }}:** {{ $formRequest->created_at->format('d.m.Y H:i') }} {{ __('messages.opening_hours.time_suffix') }}

@component('mail::button', ['url' => config('app.url')])
{{ __('messages.email.button_text') }}
@endcomponent

{!! __('messages.email.email_signature', ['app_name' => config('app.name')]) !!}
@endcomponent