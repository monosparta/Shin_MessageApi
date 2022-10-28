<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->toJson()
            ], 401);
        }

        // $request['name'] = explode('@', $request['email'])[0];

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = Auth::login($user);
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 201)->withHeaders(['authorization' => Auth::refresh(), 'type' => 'bearer']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
        ], 200)->withHeaders(['authorization' => Auth::refresh(), 'type' => 'bearer']);
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);
    //     $credentials = request(['email', 'password']);
    //     if (!Auth::attempt($credentials)) {
    //         return response()->json([
    //             'message' => 'Unauthorized',
    //         ], 401);
    //     }
    //     $user = $request->user();
    //     $accessToken = $user->createAuthToken('auth');
    //     $refreshToken = $user->createRefreshToken('refresh');

    //     $response = [
    //         'message' => 'Successfully login in!',
    //         'user' => $user,
    //         'access_token' => $accessToken,
    //         'refresh_token' => $refreshToken,
    //     ];

    //     return response(new AuthResource($response), 200);
    // }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ], 200);
    }

    public function getCSRFToken()
    {
        return csrf_token();
    }

    public function refreshToken()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
        ], 200)->withHeaders(['authorization' => Auth::refresh(), 'type' => 'bearer']);
    }
    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60
    //     ]);
    // }
}
