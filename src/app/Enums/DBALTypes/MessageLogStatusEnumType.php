<?php

namespace App\Enums\DBALTypes;

use App\Enums\Entities\MessageLogStatus;

class MessageLogStatusEnumType extends EnumType
{
    /**
     * @var string
     */
    protected $name = 'enum_message_log_status';

    /**
     * @var string
     */
    protected $class = MessageLogStatus::class;
}
