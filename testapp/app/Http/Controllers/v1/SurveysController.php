<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Surveys\StoreSurveyRequest;
use App\Http\Requests\Surveys\UpdateSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\Survey;
use App\Services\SurveysService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;

class SurveysController extends Controller
{
    /**
     * @param SurveysService $surveysService
     */
    public function __construct(private readonly SurveysService $surveysService)
    {
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Survey::query()->paginate(10);
        return SurveyResource::collection($query);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    public function show(Request $request): JsonResponse
    {
        $uri = $request->getRequestUri();
        $uriData = explode('/', $uri);
        $id = (int) last($uriData);
        return $this->successResponse($this->surveysService->getById($id));
    }

    /**
     * @param StoreSurveyRequest $request
     * @return JsonResponse
     */
    public function store(StoreSurveyRequest $request): JsonResponse
    {
        return $this->successResponse($this->surveysService->store($request->validated()), 201);
    }

    /**
     * @param Survey $survey
     * @param UpdateSurveyRequest $request
     * @return JsonResponse
     */
    public function update(Survey $survey, UpdateSurveyRequest $request): JsonResponse
    {
        return $this->successResponse($this->surveysService->update($survey, $request->validated()));
    }

    public function delete(Survey $survey): JsonResponse
    {
        if ($this->surveysService->delete($survey)) {
            return $this->successResponse(['message' => 'Deleted.'], 204);
        }

        return $this->errorResponse('Could not delete.');
    }
}
