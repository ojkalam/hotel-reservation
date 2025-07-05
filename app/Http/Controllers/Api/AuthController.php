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
            'auth_type' => 'required|string|in:passport,sanctum,jwt',
        ]);
        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 422, 'Validation Error.');
        }

        $authType = $request->input('auth_type');

        try {
            $user = User::create($validator->validated());

            switch ($authType) {
                case 'passport':
                    return $this->registerWithPassport($user);
                case 'sanctum':
                    return $this->registerWithSanctum($user);
                case 'jwt':
                    return $this->registerWithJwt($user);
                default:
                    return $this->sendErrorResponse('Invalid authentication type.', 400);
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred during registration.');
        }
    }

    /**
     * Register user with Passport.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    private function registerWithPassport(User $user)
    {
        $tokenResult = $user->createToken('auth_token');
        $token = $tokenResult->accessToken;
        $expires_in = Carbon::now()->addSeconds($tokenResult->token->expires_at->diffInSeconds(Carbon::now()));

        $response = [
            'access_token' => $token,
            'expires_in' => $expires_in,
            'token_type' => 'Bearer',
            'user' => $user,
        ];

        return $this->sendResponse($response, 201, 'User registered successfully with Passport.');
    }

    /**
     * Register user with Sanctum.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    private function registerWithSanctum(User $user)
    {
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ];

        return $this->sendResponse($response, 201, 'User registered successfully with Sanctum.');
    }

    /**
     * Register user with JWT.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    private function registerWithJwt(User $user)
    {
        // For JWT, after user creation, you might want to immediately log them in
        // and return a JWT token. This assumes the user is already authenticated
        // or you're using a different flow for JWT registration.
        // For simplicity, we'll just return a success message for now.
        // If you need to generate a JWT token here, you'd typically use JWTAuth::fromUser($user);

        $token = auth('api')->login($user);
        $expires_in = auth('api')->factory()->getTTL() * 60;

        $response = [
            'access_token' => $token,
            'expires_in' => $expires_in,
            'token_type' => 'Bearer',
            'user' => $user,
        ];

        return $this->sendResponse($response, 201, 'User registered successfully with JWT.');
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
            'auth_type' => 'required|string|in:passport,sanctum,jwt',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 422, 'Validation Error.');
        }

        $authType = $request->input('auth_type');

        switch ($authType) {
            case 'passport':
                return $this->authenticateWithPassport($request);
            case 'sanctum':
                return $this->authenticateWithSanctum($request);
            case 'jwt':
                return $this->authenticateWithJwt($request);
            default:
                return $this->sendErrorResponse('Invalid authentication type.', 400);
        }
    }

    /**
     * Authenticate user with Passport.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function authenticateWithPassport(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return $this->sendErrorResponse('Invalid login details', 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $tokenResult = $user->createToken('auth_token');
        $token = $tokenResult->accessToken;
        $expires_in = Carbon::now()->addSeconds($tokenResult->token->expires_at->diffInSeconds(Carbon::now()));

        $response = [
            'access_token' => $token,
            'expires_in' => $expires_in,
            'token_type' => 'Bearer',
            'user' => $user,
        ];

        return $this->sendResponse($response, 200, 'Login successful with Passport.');
    }

    /**
     * Authenticate user with Sanctum.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function authenticateWithSanctum(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return $this->sendErrorResponse('Invalid login details', 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ];

        return $this->sendResponse($response, 200, 'Login successful with Sanctum.');
    }

    /**
     * Authenticate user with JWT.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function authenticateWithJwt(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $token = auth('api')->attempt($credentials);

        if (!$token) {
            return $this->sendErrorResponse('Invalid login details', 401);
        }

        $expires_in = auth('api')->factory()->getTTL() * 60;
        $user = User::where('email', $request->email)->firstOrFail();

        $response = [
            'access_token' => $token,
            'expires_in' => $expires_in,
            'token_type' => 'Bearer',
            'user' => $user,
        ];

        return $this->sendResponse($response, 200, 'Login successful with JWT.');
    }

    // public function logout()
    // {
    //     auth()->logout();

    //     return response()->json(['message' => 'Successfully logged out']);
    // }
    // /**
    //  * Refresh a token.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function refresh()
    // {
    //     return auth('api')->refresh();
    // }
}
