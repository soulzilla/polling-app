<?php

namespace App\Http\Controllers\v1;

use App\DTO\ProductDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Http\Resources\ProductsResource;
use App\Models\Product;
use App\Services\ProductsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductsController extends Controller
{
    public function __construct(private readonly ProductsService $productsService)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = $this->productsService->search($request);

        return ProductsResource::collection($query->paginate(10));
    }

    public function show(Product $product): JsonResponse
    {
        return $this->successResponse($product);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $dto = ProductDTO::instance($data);
        if ($id = $this->productsService->create($dto)) {
            return $this->successResponse(['message' => 'Created.', 'id' => $id], 201);
        }

        return $this->errorResponse('Could not create.');
    }

    public function update(Product $product, UpdateProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $dto = ProductDTO::instance($data);

        if ($product = $this->productsService->update($product, $dto)) {
            return $this->successResponse(['message' => 'Updated.', 'data' => $product]);
        }

        return $this->errorResponse('Could not update.');
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->productsService->delete($product);
        return $this->successResponse(['message' => 'Deleted.'], 204);
    }

    public function buy(Product $product): JsonResponse
    {
        if ($this->productsService->buy($product)) {
            return $this->successResponse(['message' => 'Processed to buy.']);
        }

        return $this->successResponse(['message' => 'Not enough money.']);
    }
}
