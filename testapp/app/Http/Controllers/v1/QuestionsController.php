<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Questions\StoreQuestionRequest;
use App\Http\Requests\Questions\UpdateQuestionRequest;
use App\Http\Resources\QuestionsResource;
use App\Models\Question;
use App\Services\QuestionsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuestionsController extends Controller
{
    /**
     * @param QuestionsService $questionsService
     */
    public function __construct(private readonly QuestionsService $questionsService)
    {
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Question::query()->paginate(10);

        return QuestionsResource::collection($query);
    }

    /**
     * @param Question $question
     * @return JsonResponse
     */
    public function show(Question $question): JsonResponse
    {
        return $this->successResponse($question);
    }

    /**
     * @param StoreQuestionRequest $request
     * @return JsonResponse
     */
    public function store(StoreQuestionRequest $request): JsonResponse
    {
        return $this->successResponse($this->questionsService->store($request->validated()), 201);
    }

    /**
     * @param Question $question
     * @param UpdateQuestionRequest $request
     * @return JsonResponse
     */
    public function update(Question $question, UpdateQuestionRequest $request): JsonResponse
    {
        return $this->successResponse($this->questionsService->update($question, $request->validated()));
    }

    /**
     * @param Question $question
     * @return JsonResponse
     */
    public function delete(Question $question): JsonResponse
    {
        if ($this->questionsService->delete($question)) {
            return $this->successResponse(['message' => 'Deleted.'], 204);
        }

        return $this->errorResponse('Could not delete.');
    }
}
