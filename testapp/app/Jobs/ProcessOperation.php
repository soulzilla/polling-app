<?php

namespace App\Jobs;

use App\DTO\UserBalanceDTO;
use App\Enums\BalanceTypeEnum;
use App\Enums\OperationStatusEnum;
use App\Models\Balance;
use App\Models\Operation;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessOperation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Operation $operation;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Operation $operation)
    {
        $this->operation = $operation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $operation = $this->operation;

        /** @var User $user */
        $user = User::query()->find($operation->user_id);
        $user->loadSum('refills', 'amount'); // полопнения
        $user->loadSum('spends', 'amount'); // вычеты

        $balance = UserBalanceDTO::instance($user->refills_sum_amount ?? 0, $user->spends_sum_amount ?? 0, $user->id);
        /** @var Product $product */
        $product = Product::query()->find($operation->product_id);
        // ставим время обработки операции
        $operation->processed_at = date('Y-m-d H:i:s');

        // если на балансе недостаточно средств, объявляем об ошибке операции
        if ($balance->balance < $product->price) {
            $operation->status = OperationStatusEnum::FAILED->value;
            $operation->save();
            return;
        }

        $spends = new Balance();
        $spends->user_id = $user->id;
        $spends->amount = $product->price;
        $spends->type = BalanceTypeEnum::SPEND->value;
        $spends->save();

        $operation->status = OperationStatusEnum::PROCESSED->value;
        $operation->save();
    }
}
