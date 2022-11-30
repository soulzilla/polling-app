<?php

namespace App\Console\Commands;

use App\Enums\BalanceTypeEnum;
use App\Models\Balance;
use App\Models\User;
use Illuminate\Console\Command;

class RefillBalanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance:refill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refill Users Balance';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // вводим почту пользователя, на которую он зарегистрирован
        $email = $this->ask('Enter user email: ');

        /** @var User $user если пользователь не найден, выдаем ошибку, завершаем команду */
        $user = User::query()->where(['email' => $email])->first();
        if (!$user) {
            $this->error('User not found');
            return static::FAILURE;
        }

        // просим ввести сумму для зачисления
        $amount = (int) $this->ask("Enter amount to refill balance for user {$user->email}");

        // если введенная сумма больше 1000, делаем пошаговое пополнение
        $amounts = [$amount];
        if ($amount > 1000) {
            $amounts = [];
            $steps = ceil($amount/1000);
            for ($i = 1; $i <= $steps; $i++){
                if ($i == $steps) {
                    $amounts[] = $amount-(1000*($steps-1));
                    break;
                }
                $amounts[] = 1000;
            }
        }

        foreach ($amounts as $amount) {
            $balance = new Balance();
            $balance->user_id = $user->id;
            $balance->type = BalanceTypeEnum::REFILL->value;
            $balance->amount = $amount;
            $balance->save();
            $this->info('Refilled for amount: ' . $amount);
        }

        return static::SUCCESS;
    }
}
