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
                ->scalarNode('class')->defaultValue('Trsteel\CkeditorBundle\Form\Type\CkeditorType')->end()
                ->arrayNode('html_purifier')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->variableNode('config')
                            ->defaultValue(array())
                            ->info("The default html purifer config. See http://htmlpurifier.org/live/configdoc/plain.html for more information.")
                        ->end()
                    ->end()
                ->end()
                ->variableNode('transformers')
                    ->defaultValue(array('html_purifier'))
                    ->info("Default data transformers for the submitted html.")
                ->end()
                ->variableNode('toolbar')
                    ->defaultValue(array(
                        'document', 'clipboard', 'editing', '/',
                        'basicstyles', 'paragraph', 'links', '/',
                        'insert', 'styles', 'tools'
                    ))
                    ->info("The default toolbar displayed on the editor.")
                ->end()
                ->variableNode('toolbar_groups')
                    ->defaultValue(array())
                    ->info("Groups of icons in the editor.")
                ->end()
                ->booleanNode('startup_outline_blocks')
                    ->defaultTrue()
                    ->info("Whether to automaticaly enable the \"show block\" command when the editor loads.")
                ->end()
                ->scalarNode('ui_color')
                    ->defaultNull()
                    ->info("The base user interface color to be used by the editor. Must be a hex.")
                    ->example("#AADC6E")
                ->end()
                ->scalarNode('width')
                    ->defaultNull()
                    ->info("The editor UI outer width. Must be an integer or percentage.")
                    ->example("850")
                ->end()
                ->scalarNode('height')
                    ->defaultNull()
                    ->info("The height of the editing area (that includes the editor content).")
                    ->example("600")
                ->end()
                ->scalarNode('force_paste_as_plaintext')
                    ->defaultNull()
                    ->info("Force paste content as plain text.")
                ->end()
                ->scalarNode('language')
                    ->defaultNull()
                    ->info("The user interface language localization to use.")
                    ->example("en-au")
                ->end()
                ->scalarNode('disable_native_spell_checker')
                    ->defaultNull()
                    ->info("Disabled the browser's spell checker.")
                    ->example('true')
                ->end()
                ->arrayNode('filebrowser_browse_url')
                    ->addDefaultsIfNotSet()
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function ($v) { return array('url' => $v); })
                    ->end()
                    ->children()
                        ->scalarNode('url')->defaultNull()->end()
                        ->scalarNode('route')->defaultNull()->end()
                        ->variableNode('route_parameters')->defaultValue(array())->end()
                    ->end()
                    ->info("The location of an external file browser that should be launched when the Browse Server button is pressed.")
                ->end()
                ->arrayNode('filebrowser_upload_url')
                    ->addDefaultsIfNotSet()
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function ($v) { return array('url' => $v); })
                    ->end()
                    ->children()
                        ->scalarNode('url')->defaultNull()->end()
                        ->scalarNode('route')->defaultNull()->end()
                        ->variableNode('route_parameters')->defaultValue(array())->end()
                    ->end()
                    ->info("The location of the script that handles file uploads.")
                ->end()
                ->arrayNode('filebrowser_image_browse_url')
                    ->addDefaultsIfNotSet()
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function ($v) { return array('url' => $v); })
                    ->end()
                    ->children()
                        ->scalarNode('url')->defaultNull()->end()
                        ->scalarNode('route')->defaultNull()->end()
                        ->variableNode('route_parameters')->defaultValue(array())->end()
                    ->end()
                    ->info("The location of an external file browser that should be launched when the Browse Server button is pressed in the Image dialog window.")
                ->end()
                ->arrayNode('filebrowser_image_upload_url')
                    ->addDefaultsIfNotSet()
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function ($v) { return array('url' => $v); })
                    ->end()
                    ->children()
                        ->scalarNode('url')->defaultNull()->end()
                        ->scalarNode('route')->defaultNull()->end()
                        ->variableNode('route_parameters')->defaultValue(array())->end()
                    ->end()
                    ->info("The location of the script that handles file uploads in the Image dialog window.")
                ->end()
                ->arrayNode('filebrowser_flash_browse_url')
                    ->addDefaultsIfNotSet()
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function ($v) { return array('url' => $v); })
                    ->end()
                    ->children()
                        ->scalarNode('url')->defaultNull()->end()
                        ->scalarNode('route')->defaultNull()->end()
                        ->variableNode('route_parameters')->defaultValue(array())->end()
                    ->end()
                    ->info("The location of an external file browser that should be launched when the Browse Server button is pressed in the Flash dialog window.")
                ->end()
                ->arrayNode('filebrowser_flash_upload_url')
                    ->addDefaultsIfNotSet()
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function ($v) { return array('url' => $v); })
                    ->end()
                    ->children()
                        ->scalarNode('url')->defaultNull()->end()
                        ->scalarNode('route')->defaultNull()->end()
                        ->variableNode('route_parameters')->defaultValue(array())->end()
                    ->end()
                    ->info("The location of the script that handles file uploads in the Flash dialog window.")
                ->end()
                ->scalarNode('skin')
                    ->defaultNull()
                    ->info("The skin to load. It may be the name of the skin folder inside the editor installation path, or the name and the path separated by a comma.")
                ->end()
                ->variableNode('format_tags')
                    ->defaultValue(array())
                    ->info("An array of style names (by default tags) representing the style definition for each entry to be displayed in the Format combo in the toolbar.")
                    ->example('[\'p\',\'h2\',\'h3\',\'pre\']')
                ->end()
                ->scalarNode('base_path')
                    ->defaultValue('/bundles/trsteelckeditor/')
                    ->info("The base URL path used to load ckeditor files from.")
                ->end()
                ->scalarNode('base_href')
                    ->defaultNull()
                    ->info("The base href URL used to resolve relative and absolute URLs in the editor content.")
                ->end()
                ->scalarNode('body_class')
                    ->defaultNull()
                    ->info("Sets the class attribute to be used on the body element of the editing area.")
                ->end()
                ->arrayNode('contents_css')
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function ($v) { return array($v); })
                    ->end()
                    ->prototype('scalar')->end()
                    ->info("The CSS file(s) to be used to apply style to editor contents.")
                ->end()
                ->scalarNode('basic_entities')
                    ->defaultNull()
                    ->info("Whether to escape basic HTML entities in the document.")
                ->end()
                ->scalarNode('entities')
                    ->defaultNull()
                    ->info("Whether to use HTML entities in the output.")
                ->end()
                ->scalarNode('entities_latin')
                    ->defaultNull()
                    ->info("Whether to convert some Latin characters (Latin alphabet No. 1, ISO 8859-1) to HTML entities.")
                ->end()
                ->scalarNode('startup_mode')
                    ->defaultNull()
                    ->info("The mode to load at the editor startup. It depends on the plugins loaded. By default, the `wysiwyg` and `source` modes are available. ")
                ->end()
                ->scalarNode('enter_mode')
                    ->defaultNull()
                    ->info("Sets the behavior of the Enter key. By default the `ENTER_P`, `ENTER_BR` and `ENTER_DIV` modes available.")
                ->end()
                ->scalarNode('custom_config')
                    ->defaultNull()
                    ->info("The path of the custom config.js to use for the editor setup.")
                ->end()
                ->arrayNode('external_plugins')
                    ->useAttributeAsKey(true)
                    ->prototype('array')
                        ->beforeNormalization()
                        ->ifString()
                            ->then(function ($v) { return array('path' => $v); })
                        ->end()
                        ->children()
                            ->scalarNode('path')->isRequired()->end()
                            ->scalarNode('file')->defaultValue('plugin.js')->end()
                        ->end()
                    ->end()
                ->end()
                ->variableNode('templates_files')
                    ->defaultValue(array())
                    ->info("The list of templates definition files to load.")
                ->end()
                ->scalarNode('extra_allowed_content')
                    ->defaultNull()
                    ->info("This option makes it possible to set additional allowed content rules for CKEDITOR.editor.filter.")
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
