<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 28/01/19
 * Time: 11:09 ص
 */

namespace ConsumerGenerator\Model;

class ConsumerSkeleton
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $connection
     */
    protected $connection = 'default';

    /**
     * @var string $exchangeName
     */
    protected $exchangeName ;

    /**
     * @var string $exchangeType
     */
    protected $exchangeType = 'topic';

    /**
     * @var integer $qosPrefetchSize
     */
    protected $qosPrefetchSize = 0;

    /**
     * @var integer $qosPrefetchCount
     */
    protected $qosPrefetchCount = 5000;

    /**
     * @var bool $qosGlobal
     */
    protected $qosGlobal = false;

    /**
     * @var bool $enableLogger
     */
    protected $enableLogger = false;

    /**
     * @var int $idleTimeout
     */
    protected $idleTimeout = 600;

    /**
     * @var string $queueName
     */
    protected $queueName;

    /**
     * @var array $queueRoutingKeys
     */
    protected $queueRoutingKeys;

    /**
     * @var null|string $callback
     */
    protected $callback;

    /**
     * @var integer $gracefulMaxExecutionTimeout
     */
    protected $gracefulMaxExecutionTimeout = 1800;

    /**
     * @var string $amqpConsumerType
     */
    protected $amqpConsumerType;

    /**
     * @return string
     */
    public function getCallback(): string
    {
        return $this->callback;
    }

    /**
     * @param string $callback
     */
    public function setCallback(string $callback): void
    {
        $this->callback = $callback;
    }

    /**
     * @return string
     */
    public function getConnection(): string
    {
        return $this->connection;
    }

    /**
     * @param string $connection
     */
    public function setConnection(string $connection): void
    {
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    public function getExchangeName(): string
    {
        return $this->exchangeName;
    }

    /**
     * @param string $exchangeName
     */
    public function setExchangeName(string $exchangeName): void
    {
        $this->exchangeName = $exchangeName;
    }

    /**
     * @return string
     */
    public function getExchangeType(): string
    {
        return $this->exchangeType;
    }

    /**
     * @param string $exchangeType
     */
    public function setExchangeType(string $exchangeType): void
    {
        $this->exchangeType = $exchangeType;
    }

    /**
     * @return int
     */
    public function getGracefulMaxExecutionTimeout(): int
    {
        return $this->gracefulMaxExecutionTimeout;
    }

    /**
     * @param int $gracefulMaxExecutionTimeout
     */
    public function setGracefulMaxExecutionTimeout(int $gracefulMaxExecutionTimeout): void
    {
        $this->gracefulMaxExecutionTimeout = $gracefulMaxExecutionTimeout;
    }

    /**
     * @return int
     */
    public function getIdleTimeout(): int
    {
        return $this->idleTimeout;
    }

    /**
     * @param int $idleTimeout
     */
    public function setIdleTimeout(int $idleTimeout): void
    {
        $this->idleTimeout = $idleTimeout;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getQosPrefetchCount(): int
    {
        return $this->qosPrefetchCount;
    }

    /**
     * @param int $qosPrefetchCount
     */
    public function setQosPrefetchCount(int $qosPrefetchCount): void
    {
        $this->qosPrefetchCount = $qosPrefetchCount;
    }

    /**
     * @return int
     */
    public function getQosPrefetchSize(): int
    {
        return $this->qosPrefetchSize;
    }

    /**
     * @param int $qosPrefetchSize
     */
    public function setQosPrefetchSize(int $qosPrefetchSize): void
    {
        $this->qosPrefetchSize = $qosPrefetchSize;
    }

    /**
     * @return string
     */
    public function getQueueName(): string
    {
        return $this->queueName;
    }

    /**
     * @param string $queueName
     */
    public function setQueueName(string $queueName): void
    {
        $this->queueName = $queueName;
    }

    /**
     * @return array
     */
    public function getQueueRoutingKeys(): array
    {
        return $this->queueRoutingKeys;
    }

    /**
     * @param array $queueRoutingKeys
     */
    public function setQueueRoutingKeys(array $queueRoutingKeys): void
    {
        $this->queueRoutingKeys = $queueRoutingKeys;
    }

    /**
     * @return bool
     */
    public function isEnableLogger(): bool
    {
        return $this->enableLogger;
    }

    /**
     * @param bool $enableLogger
     */
    public function setEnableLogger(bool $enableLogger): void
    {
        $this->enableLogger = $enableLogger;
    }

    /**
     * @return bool
     */
    public function isQosGlobal(): bool
    {
        return $this->qosGlobal;
    }

    /**
     * @param bool $qosGlobal
     */
    public function setQosGlobal(bool $qosGlobal): void
    {
        $this->qosGlobal = $qosGlobal;
    }

    /**
     * @return string
     */
    public function getAmqpConsumerType(): string
    {
        return $this->amqpConsumerType;
    }

    /**
     * @param string $amqpConsumerType
     */
    public function setAmqpConsumerType(string $amqpConsumerType): void
    {
        $this->amqpConsumerType = $amqpConsumerType;
    }

}