<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *     title="ApiResponse",
 *     description="ApiResponse",
 *     type="object",
 *     schema="ApiResponse",
 *     properties={
 *      @OA\Property(
 *     property="status",
 *     type="boolean",
 *     ),
 *       @OA\Property(
 *     property="message",
 *     type="string",
 *     ),
 *       @OA\Property(
 *     property="data",
 *     type="object",
 *     ),
 *        @OA\Property(
 *     property="errors",
 *     type="object",
 *     ),
 *        @OA\Property(
 *     property="resultType",
 *     type="integer",
 *     )
 * }
 *)
 */
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
