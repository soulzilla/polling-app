<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $data
     * @param int $status
     * @return JsonResponse
     */
    public function successResponse($data, int $status = 200): JsonResponse
    {
        return response()->json($data)->setStatusCode($status);
    }

    /**
     * @param $message
     * @param int $status
     * @return JsonResponse
     */
    public function errorResponse($message, int $status = 400): JsonResponse
    {
        return response()->json(['message' => $message])->setStatusCode($status);
    }
}
