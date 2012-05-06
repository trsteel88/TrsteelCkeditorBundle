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
                ->variableNode('transformers')
                    ->defaultValue(array(
                        'strip_js', 'strip_css', 'strip_comments'
                    ))
                    #->setInfo("Default data transformers for the submitted html.")
                ->end()
            ->end()
            ->children()
                ->variableNode('toolbar')
                    ->defaultValue(array(
                        'document', 'clipboard', 'editing', '/',
                        'basicstyles', 'paragraph', 'links', '/',
                        'insert', 'styles', 'tools'
                    ))
                    #->setInfo("The default toolbar displayed on the editor.")
                ->end()
            ->end()
            ->children()
                ->variableNode('toolbar_groups')
                    ->defaultValue(array())
                    #->setInfo("Groups of icons in the editor.")
                ->end()
            ->end()
            ->children()
                ->booleanNode('startup_outline_blocks')
                    ->defaultTrue()
                    #->setInfo("Whether to automaticaly enable the \"show block\" command when the editor loads.")
                ->end()
            ->end()
            ->children()
                ->scalarNode('ui_color')
                    ->defaultNull()
                    #->setInfo("The base user interface color to be used by the editor. Must be a hex.")
                    #->setExample("#AADC6E")
                ->end()
            ->end()
            ->children()
                ->scalarNode('width')
                    ->defaultNull()
                    #->setInfo("The editor UI outer width. Must be an integer or percentage.")
                    #->setExample("850")
                ->end()
            ->end()
            ->children()
                ->scalarNode('height')
                    ->defaultNull()
                    #>setInfo("The height of the editing area (that includes the editor content).")
                    #->setExample("600")
                ->end()
            ->end()
            ->children()
                ->scalarNode('language')
                    ->defaultNull()
                    #->setInfo("The user interface language localization to use.")
                    #->setExample("en-au")
                ->end()
            ->end()
            ->children()
                ->scalarNode('filebrowser_browse_url')
                    ->defaultNull()
                    #->setInfo("The location of an external file browser that should be launched when the Browse Server button is pressed.")
                ->end()
            ->end()
            ->children()
                ->scalarNode('filebrowser_upload_url')
                    ->defaultNull()
                    #->setInfo("The location of the script that handles file uploads.")
                ->end()
            ->end()            
            ->children()
                ->scalarNode('filebrowser_image_browse_url')
                    ->defaultNull()
                    #->setInfo("The location of an external file browser that should be launched when the Browse Server button is pressed in the Image dialog window.")
                ->end()
            ->end()
            ->children()
                ->scalarNode('filebrowser_image_upload_url')
                    ->defaultNull()
                    #->setInfo("The location of the script that handles file uploads in the Image dialog window.")
                ->end()
            ->end()   
            ->children()
                ->scalarNode('filebrowser_flash_browse_url')
                    ->defaultNull()
                    #->setInfo("The location of an external file browser that should be launched when the Browse Server button is pressed in the Flash dialog window.")
                ->end()
            ->end()
            ->children()
                ->scalarNode('filebrowser_flash_upload_url')
                    ->defaultNull()
                    #->setInfo("The location of the script that handles file uploads in the Flash dialog window.")
                ->end()
            ->end()   
        ;

        return $treeBuilder;
    }
}
