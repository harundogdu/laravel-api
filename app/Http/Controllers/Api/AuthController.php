<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->input('password'), $user->password)) {
                $newToken = Str::random(60);
                $user->update(['api_token' => $newToken]);

                return response()->json([
                    'name' => $user->name,
                    'access_token' => $newToken,
                    'expiresAt' => now()->addMinutes(30)
                ], 200);
            }
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }
}
