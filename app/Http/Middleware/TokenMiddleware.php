<?php

namespace App\Http\Middleware;

use App\Models\SessionToken;
use Closure;
use Exception;
use Illuminate\Http\Request;

class TokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        //check if request has token
        if (!$request->hasHeader('Authorization') || !$request->header('Authorization')) {
            return response()->json(['status' => 'error', 'message' => 'No authorization token given'], 401);
        }

        //check if token is valid using SessionToken model
        $token = $request->header('Authorization');


        $sessionToken = SessionToken::where('token', $token)->first();


        if (!$sessionToken) {
            return response()->json(['status' => 'error', 'message' => 'Invalid authorization token'], 401);
        }

        if ($sessionToken->isExpired()) {
            return response()->json(['status' => 'error', 'message' => 'Authorization token expired'], 401);
        }
        try {
            //check if the game session is still active
            $sessionToken->gameCode->validate();
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], $e->getCode());
        }
        //update last used at
        $sessionToken->updateLastUsedAt();

        return $next($request);
    }
}
