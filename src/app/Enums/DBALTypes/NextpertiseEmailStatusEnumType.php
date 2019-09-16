<?php

namespace App\Enums\DBALTypes;

use App\Enums\Entities\NextpertiseEmailStatus;

class NextpertiseEmailStatusEnumType extends EnumType
{
    /**
     * @var string
     */
    protected $name = 'enum_nextpertise_email_status';

    /**
     * @var string
     */
    protected $class = NextpertiseEmailStatus::class;
}
