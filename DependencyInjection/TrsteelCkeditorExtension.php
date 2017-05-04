<?php

namespace Trsteel\CkeditorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\Kernel;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TrsteelCkeditorExtension extends Extension
{
    /**
     * {@inheritdoc}
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

        $config['toolbar_groups'] = array_merge($this->getDefaultGroups(), $config['toolbar_groups']);

        foreach ($config['external_plugins'] as &$plugin) {
            $plugin['path'] = '/'.rtrim(ltrim($plugin['path'], '/'), '/').'/';
        }

        // Ensure no leading slash on base path
        $config['base_path'] = ltrim($config['base_path'], '/');

        $config['html_purifier']['config'] = array_merge(array(
            'Cache.SerializerPath' => '%kernel.cache_dir%',
        ), $config['html_purifier']['config']);

        $container->setParameter('trsteel_ckeditor.form.type.class', $config['class']);
        $container->setParameter('trsteel_ckeditor.html_purifier.config', $config['html_purifier']['config']);
        $container->setParameter('trsteel_ckeditor.ckeditor.transformers', $config['transformers']);
        $container->setParameter('trsteel_ckeditor.ckeditor.toolbar', $config['toolbar']);
        $container->setParameter('trsteel_ckeditor.ckeditor.toolbar_groups', $config['toolbar_groups']);
        $container->setParameter('trsteel_ckeditor.ckeditor.startup_outline_blocks', $config['startup_outline_blocks']);
        $container->setParameter('trsteel_ckeditor.ckeditor.ui_color', $config['ui_color']);
        $container->setParameter('trsteel_ckeditor.ckeditor.width', $config['width']);
        $container->setParameter('trsteel_ckeditor.ckeditor.height', $config['height']);
        $container->setParameter('trsteel_ckeditor.ckeditor.force_paste_as_plaintext', $config['force_paste_as_plaintext']);
        $container->setParameter('trsteel_ckeditor.ckeditor.language', $config['language']);
        $container->setParameter('trsteel_ckeditor.ckeditor.filebrowser_browse_url', $config['filebrowser_browse_url']);
        $container->setParameter('trsteel_ckeditor.ckeditor.filebrowser_upload_url', $config['filebrowser_upload_url']);
        $container->setParameter('trsteel_ckeditor.ckeditor.filebrowser_image_browse_url', $config['filebrowser_image_browse_url']);
        $container->setParameter('trsteel_ckeditor.ckeditor.filebrowser_image_upload_url', $config['filebrowser_image_upload_url']);
        $container->setParameter('trsteel_ckeditor.ckeditor.filebrowser_flash_browse_url', $config['filebrowser_flash_browse_url']);
        $container->setParameter('trsteel_ckeditor.ckeditor.filebrowser_flash_upload_url', $config['filebrowser_flash_upload_url']);
        $container->setParameter('trsteel_ckeditor.ckeditor.skin', $config['skin']);
        $container->setParameter('trsteel_ckeditor.ckeditor.disable_native_spell_checker', $config['disable_native_spell_checker']);
        $container->setParameter('trsteel_ckeditor.ckeditor.format_tags', $config['format_tags']);
        $container->setParameter('trsteel_ckeditor.ckeditor.base_path', $config['base_path']);
        $container->setParameter('trsteel_ckeditor.ckeditor.base_href', $config['base_href']);
        $container->setParameter('trsteel_ckeditor.ckeditor.body_class', $config['body_class']);
        $container->setParameter('trsteel_ckeditor.ckeditor.contents_css', $config['contents_css']);
        $container->setParameter('trsteel_ckeditor.ckeditor.basic_entities', $config['basic_entities']);
        $container->setParameter('trsteel_ckeditor.ckeditor.entities', $config['entities']);
        $container->setParameter('trsteel_ckeditor.ckeditor.entities_latin', $config['entities_latin']);
        $container->setParameter('trsteel_ckeditor.ckeditor.startup_mode', $config['startup_mode']);
        $container->setParameter('trsteel_ckeditor.ckeditor.enter_mode', $config['enter_mode']);
        $container->setParameter('trsteel_ckeditor.ckeditor.external_plugins', $config['external_plugins']);
        $container->setParameter('trsteel_ckeditor.ckeditor.custom_config', $config['custom_config']);
        $container->setParameter('trsteel_ckeditor.ckeditor.templates_files', $config['templates_files']);
        $container->setParameter('trsteel_ckeditor.ckeditor.allowed_content', $config['allowed_content']);
        $container->setParameter('trsteel_ckeditor.ckeditor.extra_allowed_content', $config['extra_allowed_content']);
        $container->setParameter('trsteel_ckeditor.ckeditor.templates_replace_content', $config['templates_replace_content']);

        if (Kernel::VERSION_ID < 30000) {
            // BC - Add alias if Symfony < 3.0
            $container->getDefinition('trsteel_ckeditor.form.type')
                ->clearTag('form.type')
                ->addTag('form.type', array('alias' => 'ckeditor'));
        }
    }

    private function getDefaultGroups()
    {
        return array(
            'document' => array(
                'Source', '-', 'Save', '-', 'Templates',
            ),
            'clipboard' => array(
                'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo',
            ),
            'editing' => array(
                'Find', 'Replace', '-', 'SelectAll',
            ),
            'basicstyles' => array(
                'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-',
                'RemoveFormat',
            ),
            'paragraph' => array(
                'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft',
                'JustifyCenter', 'JustifyRight', 'JustifyBlock',
            ),
            'links' => array(
                'Link', 'Unlink', 'Anchor',
            ),
            'insert' => array(
                'Image', 'Flash', 'Table', 'HorizontalRule',
            ),
            'styles' => array(
                'Styles', 'Format',
            ),
            'tools' => array(
                'Maximize', 'ShowBlocks',
            ),
        );
    }
}
