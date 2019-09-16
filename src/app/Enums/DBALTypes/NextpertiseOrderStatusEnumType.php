<?php

namespace App\Enums\DBALTypes;

use App\Enums\Entities\NextpertiseOrderStatus;

class NextpertiseOrderStatusEnumType extends EnumType
{
    /**
     * @var string
     */
    protected $name = 'enum_nextpertise_order_status';

    /**
     * @var string
     */
    protected $class = NextpertiseOrderStatus::class;
}
