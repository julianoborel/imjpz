<?php

namespace App\Http\Requests\Music;

use Illuminate\Foundation\Http\FormRequest;

class MusicRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|string',
            'artist' => 'required|string',
            'notes' => 'required|string',
        ];

        return $rules;
    }
}
