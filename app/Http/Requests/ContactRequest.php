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
            'facebook_id' => 'nullable|integer|unique:contacts',
            'instagram_id' => 'nullable|string|max:30|unique:contacts',
            'email' => 'nullable|string|email|max:255|unique:contacts',
            'location_id' => 'required|integer|exists:locations,id',
            'birthday' => 'required|date',
            'interest_ids' => 'required|array',
            'interest_ids.*' => 'required|integer|exists:interests,id'
        ];
    }
}
