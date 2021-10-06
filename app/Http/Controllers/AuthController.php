<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Customer Login here
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])) {
            return response()->json(['message' => 'Access denied'], 403);
        }
        config(['auth.guards.api.provider' => 'user']);
        $user        = User::select('users.*')->find(auth()->guard('user')->user()->id);
        $tokenResult = $user->createToken('MyEcommerceApp', ['user']);
        $token       = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        return response()->json([
            'message'      => 'Login successful',
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]);
    }

    /**
     * logout
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Customer registration here
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['message' => 'Registration successful']);
    }

    /**
     * return auth user data
     *
     * @param Request $request
     * @return UserResource
     */
    public function getAuthData(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}
