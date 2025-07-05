<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 422, 'Validation Error.');
        }

        try {
            // Create user. The 'hashed' cast in the User model handles hashing automatically.
            $user = User::create($request->all());

            $token = $user->createToken('auth_token')->plainTextToken;

            $response = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ];

            return $this->sendResponse($response, 201, 'User registered successfully.');

        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred during registration.');
        }
    }

    /**
     * Authenticate an existing user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 422, 'Validation Error.');
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->sendErrorResponse('Invalid login details', 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        // $token = $user->createToken('auth_token')->plainTextToken; //use it for sanctum token
        $access_token_result = $user->createToken('auth_token'); //use it for passport token (personal client access token)
        $token = $access_token_result->accessToken; //use it for passport token
        $expires_in = Carbon::now()->addSeconds($access_token_result->expires_in); //use it for passport token
        $response = [
            'access_token' => $token,
            'expires_in' => $expires_in, //only when using passport authentication
            'token_type' => 'Bearer',
            'user' => $user,
        ];

        return $this->sendResponse($response, 200, 'Login successful.');
    }
}
