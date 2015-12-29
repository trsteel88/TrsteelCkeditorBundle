<?php

namespace Trsteel\CkeditorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * The form.type tag was removed in Symfony 3.0. Add the tag to 2.x for BC
 * More information http://symfony.com/doc/current/book/forms.html.
 */
class FormTypeCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (Kernel::VERSION_ID >= 30000) {
            return;
        }

        if (!$container->hasDefinition('trsteel_ckeditor.form.type')) {
            throw new ServiceNotFoundException('trsteel_ckeditor.form.type');
        }

        $definition = $container->getDefinition('trsteel_ckeditor.form.type');
        $definition->clearTag('form.type');
        $definition->addTag('form.type', array('alias' => 'ckeditor'));
    }
}
