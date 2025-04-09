<?php

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenExpirationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $request->bearerToken()) {
            $token = $user->tokens()
                ->where('token', hash('sha256', $request->bearerToken()))
                ->first();

            if ($token && $token->created_at->diffInMinutes(now()) >= 5) {
                $token->delete(); // Expira
                return response()->json(['message' => 'Token expirado'], 401);
            }
        }

        return $next($request);
    }
}
