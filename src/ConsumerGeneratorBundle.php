<?php

namespace ConsumerGenerator;

use ConsumerGenerator\FileSystem\ConsumerIO;
use ConsumerGenerator\Parser\ConsumerParser;
use Exception;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class ConsumerGeneratorBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     *
     * @throws Exception
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $consumerIODefinition = new Definition(
            ConsumerIO::class, [
                $container->get(Kernel::class),
                new ConsumerParser(),
            ]
        );
        $container->setDefinition(ConsumerIO::class, $consumerIODefinition);
        $generatorWrapperDefinition = new Definition(
            GeneratorWrapper::class, [
                $container->get(Kernel::class),
                $container->get(ConsumerIO::class),
            ]
        );
        $container->setDefinition(GeneratorWrapper::class, $generatorWrapperDefinition);
    }
}
