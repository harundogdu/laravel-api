<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $auth = $request->header('Authorization');

        if ($auth) {
            $token = str_replace('Bearer ', '', $auth);

            if (!$token) {
                return response()->json([
                    'message' => 'Invalid Token!'
                ], 401);
            }

            $user = User::where('api_token', $token)->first();
            if (!$user) {
                return response()->json([
                    'message' => 'User not found!'
                ], 401);
            }
            auth()->login($user);
            return $next($request);
        }

        return response()->json([
            'message' => "Unauthenticated."
        ], 401);
   }
}
