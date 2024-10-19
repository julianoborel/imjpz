<?php

namespace App\Http\Requests\Scale;

use Illuminate\Foundation\Http\FormRequest;

class ScaleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'user_ids' => 'required|array',
        ];

        return $rules;
    }
}
