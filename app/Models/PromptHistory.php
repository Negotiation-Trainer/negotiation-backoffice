<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromptHistory extends Model
{
    protected $fillable = [
        'input',
        'output',
        'input_tokens',
        'output_tokens',
        'system_fingerprint',
        'gpt_model',
        'session_token',
    ];

    public function sessionToken(): BelongsTo
    {
        return $this->belongsTo(SessionToken::class, 'session_token', 'token');
    }

    private function costs()
    {

    }
}
