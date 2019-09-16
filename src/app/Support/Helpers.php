<?php

namespace App\Support;

use PhpAmqpLib\Message\AMQPMessage;

class Helpers
{
    /**
     * Create delivery info
     *
     * @param \PhpAmqpLib\Message\AMQPMessage $message
     * @return array
     */
    public static function generateDeliveryInfoFromAMQPMessage(AMQPMessage $message) : array
    {
        return [
            'queue'         => $message->has('queue') ? $message->get('queue') : null,
            'delivery_tag'  => $message->has('delivery_tag') ? $message->get('delivery_tag') : null,
            'binding_key'   => $message->has('binding_key') ? $message->get('binding_key') : null,
            'exchange'      => $message->has('exchange') ? $message->get('exchange') : null,
            'exchange_type' => $message->has('exchange_type') ? $message->get('exchange_type') : null,
            'routing_key'   => $message->has('routing_key') ? $message->get('routing_key') : null,
            'consumer_tag'  => $message->has('consumer_tag') ? $message->get('consumer_tag') : null,
        ];
    }

    /**
     * Create delivery info from config
     *
     * @return array
     */
    public static function generateDeliveryInfoFromConfig() : array
    {
        return [
            'queue'         => config('amqp.queues.process_engine_in.queue'),
            'delivery_tag'  => null,
            'binding_key'   => null,
            'exchange'      => config('amqp.queues.process_engine_in.exchange'),
            'exchange_type' => config('amqp.queues.process_engine_in.exchange_type'),
            'routing_key'   => config('amqp.queues.process_engine_in.routing_key'),
            'consumer_tag'  => config('amqp.queues.process_engine_in.consumer_tag')
        ];
    }
}