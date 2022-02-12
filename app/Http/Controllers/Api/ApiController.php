<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function apiResponse($resultType, $data, $message = null, $status = 200): \Illuminate\Http\JsonResponse
    {
        $response = [];
        $response['success'] = $resultType === ResultType::SUCCESS;

        if (isset($data)) {
            if ($resultType !== ResultType::ERROR) {
                $response['data'] = $data;
            }

            if ($resultType === ResultType::ERROR) {
                $response['errors'] = $data;
            }
        }

        if (isset($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $status);
    }
}

class ResultType
{
    const SUCCESS = 1;
    const INFO = 2;
    const WARNING = 3;
    const ERROR = 4;
}
