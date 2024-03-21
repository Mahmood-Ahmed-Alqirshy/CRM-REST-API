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
            'datetime' => 'required|date_format:Y-m-d H:i:s',
            'annual' => 'required|boolean',
            'image' => 'string',
            'tags' => 'required|array',
            'tags.*' => 'required|integer|exists:tags,id',
            'interests' => 'required|array',
            'interests.*' => 'required|integer|exists:interests,id'
        ];
    }
}
