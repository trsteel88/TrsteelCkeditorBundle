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
			    ->arrayNode('toolbar')
					->prototype('scalar')->end()
					->defaultValue(array(
						'document', 'clipboard', 'editing', '/',
						'basicstyles', 'paragraph', 'links', '/',
						'insert', 'styles', 'tools'
					))
			    ->end()
			->end()
			->children()
				->arrayNode('toolbar_groups')
					->useAttributeAsKey('[is this right?]')
					->prototype('array')
						->prototype('scalar')->end()
					->end()
			    ->end()
			->end()
			->children()
				->booleanNode('startupOutlineBlocks')
					->defaultTrue()
				->end()
			->end()
			->children()
				->scalarNode('uiColor')
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
