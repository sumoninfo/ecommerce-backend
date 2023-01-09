<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Admin;

class AuthController extends Controller
{
    /**
     * Login here
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!auth()->guard('admin')->attempt(['email' => request('email'), 'password' => request('password')])) {
            return response()->json(['message' => 'Access denied'], 403);
        }
        config(['auth.guards.api.provider' => 'admin']);
        $admin       = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
        $admin->device_token = $request->firebase_token;
        $admin->save();
        $tokenResult = $admin->createToken('MyEcommerceApp', ['admin']);
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
     * Logout
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
     * return auth user data
     *
     * @param Request $request
     * @return UserResource
     */
    public function getAuthData(Request $request): UserResource
    {
        return new UserResource($request->user());
    }

    /* public function adminRegister(Request $request)
     {
         $admin = new Admin();
         $admin->fill($request->all());
         $admin->password = Hash::make($request->password);
         $admin->save();
         return response()->json(['message' => 'Register success']);
     }*/

}
