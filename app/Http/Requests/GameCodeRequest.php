<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'key' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
