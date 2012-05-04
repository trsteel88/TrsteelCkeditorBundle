<?php

namespace Trsteel\CkeditorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Trsteel\CkeditorBundle\DependencyInjection\Compiler\TransformerCompilerPass;

class TrsteelCkeditorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TransformerCompilerPass());
    }
}
