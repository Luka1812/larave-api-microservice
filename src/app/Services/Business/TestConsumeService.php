<?php

namespace App\Services\Business;

use App\Support\AMQP\AMQPConsumeMessageInterface;
use PhpAmqpLib\Message\AMQPMessage;

class TestConsumeService implements AMQPConsumeMessageInterface
{
    public function process(AMQPMessage $message)
    {
        // TODO: Implement process() method.
    }
}