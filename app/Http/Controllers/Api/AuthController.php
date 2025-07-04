<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 422);
        }
        try {
            if (Auth::attempt($data)) {
                $user = Auth::user();
                $response = [
                    'user' => $user,
                    // 'token' => $user->createToken('personal token'),
                ];
                return $this->sendResponse($response, '200' , 'Authenticated.');
            } else {
                return $this->sendErrorResponse('Credentials Does not matched', 401);
            }
            // return $this->sendResponse($auth_user,201, 'User created successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage());
        }
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 422, 'Validation Error.');
        }
        try {
            $user = User::create($data);
            return $this->sendResponse($user, 201, 'User created successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage());
        }
    }
}
