<?php

namespace App\Services\AMQP;

use App\Support\AMQP\AMQPService;
use Illuminate\Config\Repository as Config;
use App\Services\Business\TestSendService;
use App\Mapper\Mapper;

class TestSenderService
{
    /**
     * The Repository instance
     *
     * @var \Illuminate\Config\Repository
     */
    private $config;

    /**
     * The ProcessEngineNotificationService instance
     *
     * @var \App\Services\Business\TestSendService
     */
    private $testSendService;

    /**
     * Service constructor.
     *
     * @param \Illuminate\Config\Repository $config
     * @param \App\Services\Business\TestSendService $testSendService
     *
     * @return void
     */
    public function __construct(Config $config, TestSendService $testSendService)
    {
        $this->config          = $config;
        $this->testSendService = $testSendService;
    }

    /**
     * Notify process engine
     *
     * @param \App\Mapper\Mapper $mapper
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function notify(Mapper $mapper): void
    {
        $AMQPService = new AMQPService();
        $AMQPService->setQueueName($this->config->get('amqp.queues.test.queue'));
        $AMQPService->setExchangeName($this->config->get('amqp.queues.test.exchange'));
        $AMQPService->setExchangeType($this->config->get('amqp.queues.test.exchange_type'));
        $AMQPService->setConsumerTag($this->config->get('amqp.queues.test.consumer_tag'));
        $AMQPService->open();

        $AMQPService->send($this->testSendService, $mapper->toArray());

        $AMQPService->closeChannel();
        $AMQPService->closeConnection();
    }
}
