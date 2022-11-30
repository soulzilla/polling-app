<?php

namespace App\Enums;

enum OperationStatusEnum: int
{
    case CREATED = 0;
    case PROCESSED = 1;
    case FAILED = -1;
}
