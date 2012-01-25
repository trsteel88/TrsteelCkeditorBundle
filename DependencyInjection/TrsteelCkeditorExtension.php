<?php

namespace Trsteel\CkeditorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TrsteelCkeditorExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('twig.form.resources', array_merge(
            $container->getParameter('twig.form.resources'),
            array('TrsteelCkeditorBundle:Form:ckeditor_widget.html.twig')
        ));

        $container->setParameter('trsteel_ckeditor.form.type.class', $config['class']);
        $container->setParameter('trsteel_ckeditor.ckeditor.toolbar', $config['toolbar']);
        $container->setParameter('trsteel_ckeditor.ckeditor.toolbar_groups', array_merge($this->getDefaultGroups(), $config['toolbar_groups']));
        $container->setParameter('trsteel_ckeditor.ckeditor.startup_outline_blocks', $config['startup_outline_blocks']);
        $container->setParameter('trsteel_ckeditor.ckeditor.ui_colour', $config['ui_colour']);
        $container->setParameter('trsteel_ckeditor.ckeditor.width', $config['width']);
        $container->setParameter('trsteel_ckeditor.ckeditor.height', $config['height']);
    }

    private function getDefaultGroups()
    {
        return array(
            'document'        => array(
                'Source','-','Save','-','Templates'
            ),
            'clipboard'        => array(
                'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'
            ),
            'editing'        => array(
                'Find','Replace','-','SelectAll'
            ),
            'basicstyles'    => array(
                'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat'
            ),
            'paragraph'        => array(
                'NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft',
                'JustifyCenter','JustifyRight','JustifyBlock'
            ),
            'links'         => array(
                'Link','Unlink','Anchor'
            ),
            'insert'         => array(
                'Image','Flash','Table','HorizontalRule'
            ),
            'styles'         => array(
                'Styles','Format'
            ),
            'tools'         => array(
                'Maximize', 'ShowBlocks'
            ),
        );
    }
}
