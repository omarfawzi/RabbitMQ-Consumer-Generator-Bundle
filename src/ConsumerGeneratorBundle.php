<?php

namespace ConsumerGenerator;

use ConsumerGenerator\DependencyInjection\ConsumerGeneratorExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ConsumerGeneratorBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new ConsumerGeneratorExtension();
    }
}
