<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameConfigRequest extends FormRequest
{
    public function rules()
    {
        return [
            'game_configuration' => 'required|json'
        ];
    }
}
