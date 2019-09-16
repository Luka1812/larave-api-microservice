<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AMQP Connection
    |--------------------------------------------------------------------------
    */

    'connection' => [
        'host'   => env('RABBITMQ_HOST', null),
        'port'   => env('RABBITMQ_PORT', null),
        'user'   => env('RABBITMQ_USER', null),
        'pass'   => env('RABBITMQ_PASS', null),
        'vhosts' => env('RABBITMQ_VHOSTS', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue registration
    |--------------------------------------------------------------------------
    */

    'queues' => [
        'test' => [
            'queue'         => env('AQMP_TEST_QUEUE', null),
            'exchange'      => env('AQMP_TEST_EXCHANGE', null),
            'exchange_type' => env('AQMP_TEST_EXCHANGE_TYPE', null),
            'consumer_tag'  => env('AQMP_TEST_CONSUMER_TAG', null),
        ],
    ]
];