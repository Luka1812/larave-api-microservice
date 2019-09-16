<?php

namespace App\Enums\ErrorCodes;

final class SystemErrorCode extends Enum
{
    const ERR_OPTIMISTIC_LOCK      = 'ERR_OPTIMISTIC_LOCK';
    const ERR_PESSIMISTIC_LOCK     = 'ERR_PESSIMISTIC_LOCK';
    const ERR_FATAL                = 'ERR_FATAL';
}
