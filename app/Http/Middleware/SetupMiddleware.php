<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class SetupMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        //setup middleware, check if user count is 0
        if (User::count() === 0) {
            return $next($request);
        }

        return redirect()->route('game-sessions');
    }
}
