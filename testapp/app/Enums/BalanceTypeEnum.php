<?php

namespace App\Enums;

enum BalanceTypeEnum: int
{
    case REFILL = 1;
    case SPEND = 2;
}
