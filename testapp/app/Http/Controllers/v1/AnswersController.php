<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Services\AnswersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    /**
     * @param AnswersService $answersService
     */
    public function __construct(private readonly AnswersService $answersService)
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $variant_id = $request->post('variant_id');
        if ($answer = $this->answersService->store($variant_id)) {
            return $this->successResponse($answer, 201);
        }

        return $this->errorResponse('Forbidden.', 403);
    }

    /**
     * @param Answer $answer
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Answer $answer, Request $request): JsonResponse
    {
        $variant_id = (int) $request->all()['variant_id'];

        if ($answer = $this->answersService->update($answer, $variant_id)) {
            return $this->successResponse($answer);
        }

        return $this->errorResponse('Forbidden.', 403);
    }

    /**
     * @param Answer $answer
     * @return JsonResponse
     */
    public function delete(Answer $answer): JsonResponse
    {
        if ($this->answersService->delete($answer)) {
            return $this->successResponse(['message' => 'Deleted.'], 204);
        }

        return $this->errorResponse('Forbidden.', 403);
    }
}
