<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $user = User::all()
            ->where('username', $validated['username'])
            ->first();

        if ($user && Hash::check($validated['password'], $user->password)) {
            $token = $user->createToken($validated['username']);

            return ['token' => $token->plainTextToken];
        } else {
            return response()->json(['massage' => 'wrong password or username'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'loged out'], 200);
    }
}
