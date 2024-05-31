<?php

namespace App\Services;

use App\Models\GameCode;

class GameService
{
    public function saveConfig(string $json, int $gameId): void
    {
        if (!$this->validateConfigJSON($json)) {
            throw new \Exception('Invalid JSON');
        }

        //save the JSON to the database
        GameCode::find($gameId)->update(['game_configuration' => $json]);

    }

    public function validateConfigJSON(string $json): bool
    {
        //check that the JSON has: tribe_b, tribe_c and speakerStyle as children on both objects
        $config = json_decode($json, true);
        $tribes = ['tribe_b', 'tribe_c'];


        foreach ($tribes as $tribe) {
            if (!array_key_exists($tribe, $config)) {
                return false;
            }

            if (!array_key_exists('speakerStyle', $config[$tribe])) {
                return false;
            }
        }

        return true;
    }
}
