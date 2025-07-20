<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns'],
            'phone' => ['nullable', 'string', 'max:50'],
            'preferred_datetime' => ['nullable', 'date', 'after:now'],
            'message' => ['nullable', 'string', 'max:1000'],
            'contact_reason_id' => ['required', 'exists:contact_reasons,id,is_active,1'],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'full_name.required' => __('messages.validation.required', ['attribute' => __('messages.contact.full_name')]),
            'full_name.max' => __('messages.validation.max.string', ['attribute' => __('messages.contact.full_name'), 'max' => 255]),
            'email.required' => __('messages.validation.required', ['attribute' => __('messages.contact.email')]),
            'email.email' => __('messages.validation.email', ['attribute' => __('messages.contact.email')]),
            'email.rfc' => __('messages.validation.email.rfc', ['attribute' => __('messages.contact.email')]),
            'phone.max' => __('messages.validation.max.string', ['attribute' => __('messages.contact.phone'), 'max' => 50]),
            'preferred_datetime.date' => __('messages.validation.date', ['attribute' => __('messages.contact.preferred_datetime')]),
            'preferred_datetime.after' => __('messages.validation.after', ['attribute' => __('messages.contact.preferred_datetime')]),
            'message.max' => __('messages.validation.max.string', ['attribute' => __('messages.contact.message'), 'max' => 1000]),
            'contact_reason_id.required' => __('messages.validation.required', ['attribute' => __('messages.contact.reason')]),
            'contact_reason_id.exists' => __('messages.validation.in', ['attribute' => __('messages.contact.reason')]),
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'full_name' => __('messages.contact.full_name'),
            'email' => __('messages.contact.email'),
            'phone' => __('messages.contact.phone'),
            'preferred_datetime' => __('messages.contact.preferred_datetime'),
            'message' => __('messages.contact.message'),
            'contact_reason_id' => __('messages.contact.reason'),
        ];
    }
}
