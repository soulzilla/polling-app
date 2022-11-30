<?php

namespace App\DTO;

class UserBalanceDTO
{
    public int $balance;
    public int $user_id;

    public static function instance(int $refills, int $spends, int $user_id): UserBalanceDTO
    {
        $dto = new self();
        $dto->balance = $refills - $spends;
        $dto->user_id = $user_id;

        return $dto;
    }
}
