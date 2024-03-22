<?php

namespace App\Http\Controllers;

use App\Models\User;
use Blueprint\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $user = User::all()
            ->where('username', $request->username)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken($request->username);
            return ['token' => $token->plainTextToken];
        } else {
            return response()->json([$user, $request->username, $request->password], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'loged out'], 200);
    }
}
