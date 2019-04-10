<?php

namespace ConsumerGenerator;

use ConsumerGenerator\FileSystem\ConsumerIO;
use ConsumerGenerator\Generator\Generator;
use ConsumerGenerator\Model\ConsumerSkeleton;
use Exception;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\KernelInterface;

class GeneratorWrapper
{
    /** @var Application $application */
    protected $application;

    /** @var ConsumerIO $consumerIO */
    protected $consumerIO;

    /**
     * ConsumerService constructor.
     *
     * @param KernelInterface $kernel
     * @param ConsumerIO      $consumerIO
     */
    public function __construct(
        KernelInterface $kernel,
        ConsumerIO $consumerIO
    ) {
        $this->application = new Application($kernel);
        $this->consumerIO  = $consumerIO;
    }

    /**
     * @param Generator $generator
     *
     * @param array     $data
     *
     * @return ConsumerSkeleton[]
     */
    public function generateConsumers(Generator $generator, array $data): array
    {
        return $generator->generateConsumers($data);
    }

    /**
     * @param array  $consumers
     * @param string $path
     *
     * @param bool   $removeAll
     *
     * @throws Exception
     */
    public function removeConsumers(array $consumers, string $path , bool $removeAll = true)
    {
        $removedConsumers = $this->consumerIO->removeConsumers(
            $consumers,
            $path,
            $removeAll
        );
        $this->removeRabbitMQConsumersQueues($removedConsumers);
    }

    /**
     * @param ConsumerSkeleton[] $consumers
     *
     * @throws Exception
     */
    public function removeRabbitMQConsumersQueues(array $consumers)
    {
        foreach ($consumers as $consumer) {
            $input           = new ArrayInput(
                [
                    'command' => 'rabbitmq:delete',
                    'name'    => $consumer->getName()
                ]
            );
            $output          = new BufferedOutput();
            $ranSuccessfully = $this->application->run($input, $output) == 0 ? true : false;
            if (!$ranSuccessfully) {
                throw new Exception($output->fetch());
            }
        }
    }

    /**
     * @param ConsumerSkeleton[] $consumers
     * @param string             $path
     */
    public function writeConsumers(array $consumers, string $path)
    {
        $this->consumerIO->writeConsumers(
            $consumers,
            $path
        );
    }

    /**
     * @throws Exception
     */
    public function setupFabric()
    {
        $input           = new ArrayInput(
            [
                'command' => 'rabbitmq:setup-fabric',
            ]
        );
        $output          = new BufferedOutput();
        $ranSuccessfully = $this->application->run($input, $output) == 0 ? true : false;
        if (!$ranSuccessfully) {
            throw new Exception($output->fetch());
        }
    }
}