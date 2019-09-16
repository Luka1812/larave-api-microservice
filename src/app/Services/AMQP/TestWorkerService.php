<?php

namespace App\Services\OneView;

use Illuminate\Config\Repository as Config;
use App\Support\AMQP\AMQPService;
use App\Services\Business\TestService;

class TestWorkerService
{
    /**
     * The Repository instance
     *
     * @var \Illuminate\Config\Repository
     */
    private $config;

    /**
     * The TestService instance
     *
     * @var \App\Services\Business\TestService
     */
    private $testService;

    /**
     * Create a new console command instance.
     *
     * @param \Illuminate\Config\Repository as Config $config
     * @param \App\Services\Business\TestService $testService
     */
    public function __construct(Config $config, TestService $testService)
    {
        $this->config      = $config;
        $this->testService = $testService;
    }

    /**
     * Process the message
     */
    public function handle()
    {
        $AMQPService = new AMQPService();

        $AMQPService->setQueueName($this->config->get('amqp.queues.test.queue'));
        $AMQPService->setExchangeName($this->config->get('amqp.queues.test.exchange'));
        $AMQPService->setExchangeType($this->config->get('amqp.queues.test.exchange_type'));
        $AMQPService->setConsumerTag($this->config->get('amqp.queues.test.consumer_tag'));
        $AMQPService->open();

        $AMQPService->consume($this->testService);

        $AMQPService->closeChannel();
        $AMQPService->closeConnection();
    }
}
