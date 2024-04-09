<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GameSessionUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:game_codes,id'], // 'exists' rule added to check if the id exists in the 'game_codes' table
            'name' => ['required'],
            'key' => [
                'required',
                Rule::exists('game_codes', 'key'),
                Rule::unique('game_codes', 'key')->ignore($this->id)
            ],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ];
    }
}
