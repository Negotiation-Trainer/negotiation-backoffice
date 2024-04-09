<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SessionToken extends Model
{
    protected $fillable = [
        'token',
        'last_used_at',
        'expires_at',
        'game_code_id'
    ];

    public function isExpired(): bool
    {
        return $this->expires_at < now();
    }

    public function updateLastUsedAt(): void
    {
        $this->last_used_at = now();
        $this->updateExpiration();
        $this->save();
    }

    private function updateExpiration(): void
    {
        $this->expires_at = now()->addHour();
        $this->save();
    }

    public static function NewSessionToken(int $gameCodeId): SessionToken
    {
        return self::create([
            'token' => bin2hex(random_bytes(16)),
            'expires_at' => now()->addHour(),
            'game_code_id' => $gameCodeId
        ]);
    }

    protected function gameCode(): BelongsTo
    {
        return $this->belongsTo(GameCode::class, 'game_code_id', 'id');
    }

    protected function promptsList(): HasMany
    {
        return $this->hasMany(PromptHistory::class, 'session_token', 'token');
    }

    public function revoke(): void
    {
        $this->expires_at = now()->subYear();
        $this->save();
    }

}
