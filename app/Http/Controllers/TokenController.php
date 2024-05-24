<?php

namespace App\Http\Controllers;

use App\Models\SessionToken;
use Illuminate\Http\JsonResponse;

class TokenController extends Controller
{
    public function revoke(SessionToken $token): JsonResponse
    {
        $token->revoke();

        return response()->json([
            'message' => 'Token revoked'
        ]);
    }
}
