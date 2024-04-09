<?php

namespace App\Http\Controllers;

use App\Models\SessionToken;

class TokenController extends Controller
{
    public function revoke(SessionToken $token)
    {
        $token->revoke();

        return response()->json([
            'message' => 'Token revoked'
        ]);
    }
}
