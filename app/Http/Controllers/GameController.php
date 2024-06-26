<?php

namespace App\Http\Controllers;

use App\Models\GameCode;
use App\Models\SessionToken;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\ItemNotFoundException;
use Illuminate\Validation\ValidationException;

class GameController extends Controller
{
    /**
     * @throws Exception
     */
    public function authenticateGameSession(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'sessionPassword' => 'required|string'
            ]);

            //find the session password in the database
            $gameSession = GameCode::where('key', $validated['sessionPassword'])->first();

            if (!$gameSession) {
                throw new ItemNotFoundException('Invalid session password');
            }

            $gameSession->validate();

            $token = SessionToken::NewSessionToken($gameSession->id);

            return response()->json([
                'status' => 'success',
                'token' => $token->token,
            ]);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->errors()], 401);
        } catch (ItemNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Returns the JSON Game Configuration
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function gameConfig(Request $request): JsonResponse
    {
        $token = $request->header('Authorization');

        //use the token to find the game session
        $game = SessionToken::where('token', $token)->first()->gameCode;

        return response()->json([
            'status' => 'success',
            'game_code' => $game->key,
            'game_configuration' => json_decode($game->game_configuration, true)
        ]);
    }
}
