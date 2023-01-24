<?php

namespace Trsteel\CkeditorBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Trsteel\CkeditorBundle\DependencyInjection\Compiler\TransformerCompilerPass;

class TrsteelCkeditorBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new TransformerCompilerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 0);
    }
}
