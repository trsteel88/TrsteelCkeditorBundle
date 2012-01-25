<?php

namespace Trsteel\CkeditorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('trsteel_ckeditor');

        $rootNode
            ->children()
                ->scalarNode('class')
                    ->defaultValue('Trsteel\CkeditorBundle\Form\CkeditorType')
                ->end()
            ->end()
            ->children()
                ->variableNode('toolbar')
                    ->defaultValue(array(
                        'document', 'clipboard', 'editing', '/',
                        'basicstyles', 'paragraph', 'links', '/',
                        'insert', 'styles', 'tools'
                    ))
                ->end()
            ->end()
            ->children()
                ->variableNode('toolbar_groups')
                    ->defaultValue(array())
                ->end()
            ->end()
            ->children()
                ->booleanNode('startup_outline_blocks')
                    ->defaultTrue()
                ->end()
            ->end()
            ->children()
                ->scalarNode('ui_colour')
                    ->defaultNull()
                ->end()
            ->end()
            ->children()
                ->scalarNode('width')
                    ->defaultNull()
                ->end()
            ->end()
            ->children()
                ->scalarNode('height')
                    ->defaultNull()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
