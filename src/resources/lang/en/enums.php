<?php

use App\Enums\ErrorCodes\AMQPErrorCode;
use App\Enums\ErrorCodes\SystemErrorCode;

return [
    AMQPErrorCode::class => [
        AMQPErrorCode::ERR_WRONG_EXCHANGE_TYPE => 'The wrong exchange type has been provided.',
        AMQPErrorCode::ERR_MISSING_QUEUE_NAME  => 'Queue name is required.',
        AMQPErrorCode::ERR_INIT_FAILED         => 'Init process has failed.',
        AMQPErrorCode::ERR_EMPTY_PAYLOAD       => 'Cannot send empty payload.',
    ],

    SystemErrorCode::class => [
        SystemErrorCode::ERR_FATAL                => 'Something went wrong.',
    ],
];
