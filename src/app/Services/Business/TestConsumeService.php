<?php

namespace App\Services\Business;

use App\Support\AMQP\AMQPConsumeMessageInterface;
use PhpAmqpLib\Message\AMQPMessage;
use App\Support\Json;
use App\Validations\TestValidation;

class TestConsumeService implements AMQPConsumeMessageInterface
{
    /**
     * The TestValidation instance
     * @var \App\Validations\TestValidation
     */
    private $validation;

    /**
     * The abstract service constructor.
     * @param \App\Validations\TestValidation $validation
     * @return void
     */
    public function __construct(TestValidation $validation)
    {
        $this->validation = $validation;
    }

    public function process(AMQPMessage $message)
    {
        // TODO: Implement process() method.

        $data = Json::decode($message->getBody());

        $this->validation->validate($data['data']);
    }
}