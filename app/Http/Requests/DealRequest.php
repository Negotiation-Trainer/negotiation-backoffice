<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'speakerStyle' => 'required|string|max:255',
            'reason' => 'required|string|max:255',
            'RequestedItem' => 'required|string|max:255',
            'RequestedAmount' => 'required|string|max:255',
            'OfferedItem' => 'required|string|max:255',
            'OfferedAmount' => 'required|string|max:255',
        ];
    }
}
