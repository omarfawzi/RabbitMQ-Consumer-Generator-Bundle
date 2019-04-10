<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 28/01/19
 * Time: 04:20 م
 */

namespace ConsumerGenerator\Generator;

use ConsumerGenerator\Model\ConsumerSkeleton;

/**
 * Class Generator
 *
 * @package Generator
 *
 * This class is responsible for generating all consumers
 */
interface Generator
{
    public const EXCHANGE_DIRECT_TYPE = 'direct';
    /**
     * @param array $data
     *
     * @return ConsumerSkeleton[]
     */
    public function generateConsumers(array $data): array;
}