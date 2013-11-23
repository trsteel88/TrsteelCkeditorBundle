<?php

namespace Trsteel\CkeditorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class TransformerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('trsteel_ckeditor.form.type')) {
            return;
        }

        $definition = $container->getDefinition('trsteel_ckeditor.form.type');

        foreach ($container->findTaggedServiceIds('trsteel_ckeditor.transformer') as $id => $attributes) {
            $definition->addMethodCall('addTransformer', array(new Reference($id), $attributes[0]['alias']));
        }
    }
}
