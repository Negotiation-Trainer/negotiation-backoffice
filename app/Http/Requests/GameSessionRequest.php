<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GameSessionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'key' => ['required', Rule::unique('game_codes', 'key')],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ];
    }
}
