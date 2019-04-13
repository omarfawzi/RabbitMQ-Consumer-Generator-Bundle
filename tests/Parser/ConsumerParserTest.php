<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 03/02/19
 * Time: 12:32 م
 */

namespace ConsumerGenerator\Tests\Parser;

use ConsumerGenerator\Model\ConsumerSkeleton;
use ConsumerGenerator\Parser\ConsumerParser;
use Illuminate\Support\Arr;
use PHPUnit\Framework\TestCase;

class ConsumerParserTest extends TestCase
{
    /**
     * @return ConsumerSkeleton
     */
    public function getFakeConsumer(): ConsumerSkeleton
    {
        $fakeData = [
            'name'                        => 'name1',
            'connection'                  => 'default',
            'exchangeName'                => 'name2',
            'exchangeType'                => 'type1',
            'qosPrefetchSize'             => 1,
            'qosPrefetchCount'            => 2,
            'qosGlobal'                   => true,
            'enableLogger'                => false,
            'idleTimeout'                 => 3,
            'queueName'                   => 'name3',
            'queueRoutingKeys'            => ['random'],
            'callback'                    => 'callback1',
            'gracefulMaxExecutionTimeout' => 4,
            'amqpConsumerType'            => Arr::random(ConsumerParser::CONSUMER_TYPES),
        ];
        $consumer = new ConsumerSkeleton();
        foreach ($fakeData as $key => $data) {
            $setFunction = 'set'.ucfirst($key);
            $consumer->$setFunction($data);
        }

        return $consumer;
    }

    public function testParseConsumersToArray()
    {
        $consumer = [$this->getFakeConsumer()];
        $consumerParser = new ConsumerParser();
        $result   = $consumerParser->parseConsumersToArray($consumer);
        $head     = key($result);
        $type     = key(Arr::first($result));
        $this->assertEquals(ConsumerParser::OLD_SOUND_RABBIT_MQ, $head);
        $this->assertContains($type, ConsumerParser::CONSUMER_TYPES);
        $expected = [
            "name1" => [
                "connection"             => "default",
                "exchange_options"       => [
                    "name" => "name2",
                    "type" => "type1",
                ],
                "qos_options"            => [
                    "prefetch_size"  => 1,
                    "prefetch_count" => 2,
                    "global"         => true,
                ],
                "enable_logger"          => false,
                "idle_timeout"           => 3,
                "queue_options"          => [
                    "name"         => "name3",
                    "routing_keys" => [
                        0 => "random",
                    ],
                ],
                "callback"               => $result[$head][$type]['name1']['callback'],
                "graceful_max_execution" => [
                    "timeout" => 4,
                ],
            ],
        ];
        $this->assertEquals($expected, $result[$head][$type]);
    }

}