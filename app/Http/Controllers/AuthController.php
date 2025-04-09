<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function refresh(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        $newToken = $request->user()->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $newToken], 200);
    }
}