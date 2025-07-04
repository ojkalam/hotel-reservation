<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
class BaseController extends Controller
{
    //send succes response
    public function sendResponse($data, $status_code = 200, $message = 'SUCCESS', $headers = [])
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'api_version' => config('api.API_VERSION'),
        ];
        return response()->json($response, $status_code, $headers);
    }

    public function sendErrorResponse($error_messages, $status_code = 500, $message = 'ERROR', $headers = [])
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $error_messages,
            'api_version' => config('api.API_VERSION'),
        ];
        return response()->json($response, $status_code, $headers);
    }
}
