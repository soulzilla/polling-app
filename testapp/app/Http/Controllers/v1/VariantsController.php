<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Variants\StoreVariantRequest;
use App\Http\Requests\Variants\UpdateVariantRequest;
use App\Http\Resources\VariantsResource;
use App\Models\Variant;
use App\Services\VariantsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VariantsController extends Controller
{
    /**
     * @param VariantsService $variantsService
     */
    public function __construct(private readonly VariantsService $variantsService)
    {
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Variant::query()->paginate(10);

        return VariantsResource::collection($query);
    }

    /**
     * @param Variant $variant
     * @return JsonResponse
     */
    public function show(Variant $variant): JsonResponse
    {
        return $this->successResponse($variant);
    }

    /**
     * @param StoreVariantRequest $request
     * @return JsonResponse
     */
    public function store(StoreVariantRequest $request): JsonResponse
    {
        return $this->successResponse($this->variantsService->store($request->validated()), 201);
    }

    /**
     * @param Variant $variant
     * @param UpdateVariantRequest $request
     * @return JsonResponse
     */
    public function update(Variant $variant, UpdateVariantRequest $request): JsonResponse
    {
        return $this->successResponse($this->variantsService->update($variant, $request->validated()));
    }

    /**
     * @param Variant $variant
     * @return JsonResponse
     */
    public function delete(Variant $variant): JsonResponse
    {
        if ($this->variantsService->delete($variant)) {
            return $this->successResponse(['message' => 'Deleted.'], 204);
        }

        return $this->errorResponse('Could not delete.');
    }
}
