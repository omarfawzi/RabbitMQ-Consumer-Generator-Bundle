<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 30/01/19
 * Time: 04:36 م
 */

namespace ConsumerGenerator\FileSystem;

use ConsumerGenerator\Model\ConsumerSkeleton;
use ConsumerGenerator\Parser\ConsumerParser;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ConsumerIO
 *
 * @package ConsumerGenerator\FileSystem
 *
 * This class is responsible for any I/O operation on the yaml file
 */
class ConsumerIO
{
    private const OLD_SOUND_RABBIT_MQ_PATH = 'config/packages/old_sound_rabbit_mq';

    private const FILE_EXTENSION = 'yml';

    /** @var string $rootDirectory */
    protected $rootDirectory;

    /** @var ConsumerParser $consumerParser */
    protected $consumerParser;

    public function __construct(KernelInterface $kernel, ConsumerParser $consumerParser)
    {
        $this->rootDirectory  = $kernel->getProjectDir();
        $this->consumerParser = $consumerParser;
    }

    /**
     * @param string $path
     *
     * @return ConsumerSkeleton[]
     */
    public function getConsumers(string $path): array
    {
        $fullPath = $this->getFullPath($path);
        if (!file_exists($fullPath)) {
            return [];
        }

        return $this->consumerParser->parseArrayToConsumers(Yaml::parseFile($fullPath) ?? []);
    }

    /**
     * @param ConsumerSkeleton[] $consumers
     * @param string             $path
     *
     * @param bool               $removeAll
     *
     * @return ConsumerSkeleton[]
     */
    public function removeConsumers(array $consumers, string $path, bool $removeAll = false)
    {
        $fullPath = $this->getFullPath($path);
        if (!file_exists($fullPath)) {
            return [];
        }
        $allConsumers = $this->consumerParser->parseArrayToConsumers(Yaml::parseFile($fullPath) ?? []);
        unlink($fullPath);
        if (!$removeAll) {
            $notDeletedConsumers = array_udiff(
                $allConsumers,
                $consumers,
                function (ConsumerSkeleton $a, ConsumerSkeleton $b) {
                    return $a->getName() != $b->getName();
                }
            );
            if (count($notDeletedConsumers)) {
                $this->writeToFile($this->serializeYamlConsumers($notDeletedConsumers), $fullPath);
            }

            return $consumers;
        }

        return $allConsumers;
    }

    /**
     * @param ConsumerSkeleton[] $consumers
     * @param string             $path
     */
    public function writeConsumers(array $consumers, string $path)
    {
        $fullPath         = $this->getFullPath($path);
        $consumersToWrite = $consumers;
        if (file_exists($fullPath)) {
            $oldConsumers     = $this->consumerParser->parseArrayToConsumers(
                Yaml::parseFile($fullPath) ?? []
            );
            $consumersToWrite = array_merge($consumersToWrite, $oldConsumers);
        }
        $this->writeToFile($this->serializeYamlConsumers($consumersToWrite), $fullPath);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function getFullPath(string $path): string
    {
        return $this->rootDirectory.'/'.self::OLD_SOUND_RABBIT_MQ_PATH.'/'.$path.'.'.self::FILE_EXTENSION;
    }

    /**
     * @param ConsumerSkeleton[] $consumers
     *
     * @return string
     */
    private function serializeYamlConsumers(array $consumers)
    {
        $consumersArray = $this->consumerParser->parseConsumersToArray($consumers);

        return Yaml::dump($consumersArray);
    }

    /**
     * @param string $serializedConsumers
     * @param string $fullPath
     */
    private function writeToFile(string $serializedConsumers, string $fullPath)
    {
        file_put_contents(
            $fullPath,
            $serializedConsumers
        );
    }

}