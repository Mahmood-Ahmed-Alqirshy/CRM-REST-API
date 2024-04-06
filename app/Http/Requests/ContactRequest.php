<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|regex:/^[\p{L}\p{M}\s]+$/u|max:255',
            'phone' => 'nullable|string|regex:/^[\d]+$/|min:9|max:9|unique:contacts',
            'social_media_links' => 'sometimes|string|json',
            'email' => 'nullable|string|email|max:255|unique:contacts',
            'location_id' => 'required|integer|exists:locations,id',
            'birth_date' => 'required|date|date_format:Y-m-d',
            'interest_ids' => 'present|array',
            'interest_ids.*' => 'integer|exists:interests,id'
        ];
    }
}
