<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OperationsResource;
use App\Services\OperationsService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OperationsController extends Controller
{
    public function __construct(private readonly OperationsService $operationsService)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = $this->operationsService->search($request);

        return OperationsResource::collection($query->paginate(10));
    }
}
