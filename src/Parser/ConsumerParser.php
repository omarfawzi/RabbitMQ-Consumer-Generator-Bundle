<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 28/01/19
 * Time: 04:44 م
 */

namespace ConsumerGenerator\Parser;

use ConsumerGenerator\Model\ConsumerSkeleton;

/**
 * Class ConsumerParser
 *
 * @package ConsumerGenerator\Parser
 *
 * This class parses an array of ConsumerSkeleton objects to their associative array representation
 */
class ConsumerParser
{
    public const BATCH_CONSUMERS                = 'batch_consumers';
    public const ORDINARY_CONSUMERS             = 'consumers';
    public const CONNECTION                     = 'connection';
    public const EXCHANGE_OPTIONS               = 'exchange_options';
    public const EXCHANGE_NAME                  = 'name';
    public const EXCHANGE_TYPE                  = 'type';
    public const QOS_OPTIONS                    = 'qos_options';
    public const QOS_PREFETCH_SIZE              = 'prefetch_size';
    public const QOS_PREFETCH_COUNT             = 'prefetch_count';
    public const QOS_GLOBAL                     = 'global';
    public const ENABLE_LOGGER                  = 'enable_logger';
    public const IDLE_TIMEOUT                   = 'idle_timeout';
    public const QUEUE_OPTIONS                  = 'queue_options';
    public const QUEUE_NAME                     = 'name';
    public const QUEUE_ROUTING_KEYS             = 'routing_keys';
    public const CALLBACK                       = 'callback';
    public const GRACEFUL_MAX_EXECUTION         = 'graceful_max_execution';
    public const GRACEFUL_MAX_EXECUTION_TIMEOUT = 'timeout';
    public const OLD_SOUND_RABBIT_MQ            = 'old_sound_rabbit_mq';

    public const CONSUMER_TYPES = [
        self::BATCH_CONSUMERS,
        self::ORDINARY_CONSUMERS
    ];

    /**
     * @param array $consumers
     *
     * @return ConsumerSkeleton[]
     */
    public function parseArrayToConsumers(array $consumers): array
    {
        $parsedConsumers = [];
        foreach ($consumers as $contents) {
            foreach ($contents as $type => $content) {
                $consumerNames = array_keys($content);
                foreach ($consumerNames as $consumerName) {
                    $consumer = new ConsumerSkeleton();
                    $consumer->setName($consumerName);
                    $consumer->setConnection($content[$consumerName][self::CONNECTION]);
                    $consumer->setExchangeName($content[$consumerName][self::EXCHANGE_OPTIONS][self::EXCHANGE_NAME]);
                    $consumer->setExchangeType($content[$consumerName][self::EXCHANGE_OPTIONS][self::EXCHANGE_TYPE]);
                    $consumer->setQosPrefetchSize($content[$consumerName][self::QOS_OPTIONS][self::QOS_PREFETCH_SIZE]);
                    $consumer->setQosPrefetchCount($content[$consumerName][self::QOS_OPTIONS][self::QOS_PREFETCH_COUNT]);
                    $consumer->setQosGlobal($content[$consumerName][self::QOS_OPTIONS][self::QOS_GLOBAL]);
                    $consumer->setEnableLogger($content[$consumerName][self::ENABLE_LOGGER]);
                    $consumer->setIdleTimeout($content[$consumerName][self::IDLE_TIMEOUT]);
                    $consumer->setQueueName($content[$consumerName][self::QUEUE_OPTIONS][self::QUEUE_NAME]);
                    $consumer->setQueueRoutingKeys($content[$consumerName][self::QUEUE_OPTIONS][self::QUEUE_ROUTING_KEYS]);
                    $consumer->setCallback($content[$consumerName][self::CALLBACK]);
                    $consumer->setGracefulMaxExecutionTimeout(
                        $content[$consumerName][self::GRACEFUL_MAX_EXECUTION][self::GRACEFUL_MAX_EXECUTION_TIMEOUT]
                    );
                    $consumer->setAmqpConsumerType($type);
                    $parsedConsumers[] = $consumer;
                }

            }
        }

        return $parsedConsumers;
    }

    /**
     * @param ConsumerSkeleton[] $consumers
     *
     * @return array
     */
    public function parseConsumersToArray(array $consumers): array
    {
        $parsedConsumers = [];
        foreach ($consumers as $consumer) {
            $parsedConsumers[self::OLD_SOUND_RABBIT_MQ]
            [$consumer->getAmqpConsumerType()]
            [$consumer->getName()]
                = $this->parseConsumerToArray(
                $consumer
            );
        }

        return $parsedConsumers;
    }

    /**
     * @param ConsumerSkeleton $consumer
     *
     * @return array
     */
    private function parseConsumerToArray(ConsumerSkeleton $consumer): array
    {
        return [
            self::CONNECTION             => $consumer->getConnection(),
            self::EXCHANGE_OPTIONS       => [
                self::EXCHANGE_NAME => $consumer->getExchangeName(),
                self::EXCHANGE_TYPE => $consumer->getExchangeType(),
            ],
            self::QOS_OPTIONS            => [
                self::QOS_PREFETCH_SIZE  => $consumer->getQosPrefetchSize(),
                self::QOS_PREFETCH_COUNT => $consumer->getQosPrefetchCount(),
                self::QOS_GLOBAL         => $consumer->isQosGlobal(),
            ],
            self::ENABLE_LOGGER          => $consumer->isEnableLogger(),
            self::IDLE_TIMEOUT           => $consumer->getIdleTimeout(),
            self::QUEUE_OPTIONS          => [
                self::QUEUE_NAME         => $consumer->getQueueName(),
                self::QUEUE_ROUTING_KEYS => $consumer->getQueueRoutingKeys(),
            ],
            self::CALLBACK               => $consumer->getCallback(),
            self::GRACEFUL_MAX_EXECUTION => [
                self::GRACEFUL_MAX_EXECUTION_TIMEOUT => $consumer->getGracefulMaxExecutionTimeout(),
            ],
        ];
    }
}
