<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TradeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'speakerStyle' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'originator' => 'required|string|max:255',
            'RequestedItem' => 'required|string|max:255',
            'RequestedAmount' => 'required|integer|max:255',
            'OfferedItem' => 'required|string|max:255',
            'OfferedAmount' => 'required|integer|max:255',
        ];
    }
}
