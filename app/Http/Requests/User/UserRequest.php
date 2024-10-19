<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string',
            'number' => 'required|string',
            'password' => 'required|string',
            'attribute_id' => 'required|array',
        ];

        return $rules;
    }
}
