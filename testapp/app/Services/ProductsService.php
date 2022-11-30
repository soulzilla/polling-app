<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\DTO\UserBalanceDTO;
use App\Models\Product;
use App\Models\User;
use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductsService
{
    use SearchTrait;

    protected string $modelClass = Product::class;

    public function __construct(private readonly OperationsService $operationsService)
    {
    }

    public function prepareQuery(Builder$query, Request $request): Builder
    {
        if ($request->has('id')) {
            $ids = $request->get('id');
            $query->whereIn('id', is_array($ids) ? $ids : [$ids]);
        }

        if ($request->has('name')) {
            $query->where('name', 'ilike', '%' . $request->get('name') . '%');
        }

        if ($request->has('price')) {
            $query->where(['price' => $request->get('price')]);
        }

        return $query;
    }

    public function create(ProductDTO $dto): bool|int
    {
        /** @var Product $product */
        $product = Product::query()->create([
            'name' => $dto->name,
            'price' => $dto->price,
        ]);

        if ($product) {
            return $product->id;
        }

        return false;
    }

    public function update(Product $product, ProductDTO $dto): bool|Product
    {
        $product->name = $dto->name ?? $product->name;
        $product->price = $dto->price ?? $product->price;
        if ($product->save()) {
            return $product;
        }

        return false;
    }

    public function delete(Product $product): ?bool
    {
        return $product->delete();
    }

    public function buy(Product $product): bool
    {
        /** @var User $user */
        $user = auth()->user();
        $user->loadSum('refills', 'amount'); // полопнения
        $user->loadSum('spends', 'amount'); // вычеты

        // загружаем данные о балансе
        $balance = UserBalanceDTO::instance($user->refills_sum_amount ?? 0, $user->spends_sum_amount ?? 0, $user->id);
        // если недостаточно денег, завершаем операцию, выдаем ошибку
        if ($balance->balance < $product->price) {
            return false;
        }

        // разделим ответственность за создание операции отдельному сервису
        $this->operationsService->buy($user, $product);

        return true;
    }
}
