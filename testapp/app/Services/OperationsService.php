<?php

namespace App\Services;

use App\Enums\OperationStatusEnum;
use App\Jobs\ProcessOperation;
use App\Models\Operation;
use App\Models\Product;
use App\Models\User;
use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OperationsService
{
    use SearchTrait;

    protected string $modelClass = Operation::class;

    public function prepareQuery(Builder $query, Request $request): Builder
    {
        if ($request->has('id')) {
            $ids = $request->get('id');
            $query->whereIn('id', is_array($ids) ? $ids : [$ids]);
        }

        if ($request->has('user_id')) {
            $query->where(['user_id' => $request->get('user_id')]);
        }

        if ($request->has('status')) {
            $query->where(['status' => $request->get('status')]);
        }

        if ($request->has('processed_at')) {
            $query->where('processed_at', '>', $request->get('processed_at'));
        }

        if ($request->has('created_at')) {
            $query->where('created_at', '>', $request->get('created_at'));
        }

        return $query;
    }

    public function buy(User $user, Product $product): Operation
    {
        // создаем запись о проведении операции, без вычета денег из баланса, так как это будет обрабатываться фоново
        $operation = new Operation();
        $operation->user_id = $user->id;
        $operation->product_id = $product->id;
        $operation->status = OperationStatusEnum::CREATED->value;
        $operation->save();

        // добавляем задачу обработки операции в очередь
        ProcessOperation::dispatch($operation);

        return $operation;
    }
}
