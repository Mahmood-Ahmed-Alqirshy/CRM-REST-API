<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'heading' => 'required|string|max:255',
            'description' => 'required|string',
            'datetime' => 'required|date|date_format:Y-m-d H:i:s',
            'is_annual' => 'required|boolean',
            'image' => 'string',
            'tag_ids' => 'present|array',
            'tag_ids.*' => 'integer|exists:tags,id',
            'interest_ids' => 'present|array',
            'interest_ids.*' => 'integer|exists:interests,id'
        ];
    }
}
