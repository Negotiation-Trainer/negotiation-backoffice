<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $sessionList
 */
class GameCode extends Model
{
    protected $fillable = [
        'name',
        'key',
        'start_date',
        'end_date',
    ];

    public static function attempt($key): bool
    {
        //find the game code
        $gameCode = self::where('key', $key)->first();

        //if the game code is not found, return false
        if (!$gameCode) {
            return false;
        }

        //if the game code is found, validate the time
        return $gameCode->validateTime();
    }

    public function validateTime(): bool
    {
        return $this->start_date < now() && $this->end_date > now();
    }

    /**
     * @throws Exception
     */
    public function validate(): void
    {
        if (!$this->validateTime()) {
            throw new Exception('Game Session ' . $this->key . ' has expired', 410);
        }
    }

    protected function sessionList(): HasMany
    {
        //get all sessions that have used this game key
        return $this->hasMany(SessionToken::class, 'game_code_id', 'id');
    }
}
