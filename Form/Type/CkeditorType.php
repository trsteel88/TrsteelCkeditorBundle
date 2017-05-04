<?php

namespace Trsteel\CkeditorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * CKEditor type.
 */
class CkeditorType extends AbstractType
{
    protected $container;
    protected $transformers;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function addTransformer(DataTransformerInterface $transformer, $alias)
    {
        if (isset($this->transformers[$alias])) {
            throw new \Exception('Transformer alias must be unique.');
        }
        $this->transformers[$alias] = $transformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['transformers'] as $transformer_alias) {
            if (isset($this->transformers[$transformer_alias])) {
                $builder->addViewTransformer($this->transformers[$transformer_alias]);
            } else {
                throw new \Exception(sprintf("'%s' is not a valid transformer.", $transformer_alias));
            }
        }

        $options['toolbar_groups'] = array_merge($this->container->getParameter('trsteel_ckeditor.ckeditor.toolbar_groups'), $options['toolbar_groups']);

        $builder
            ->setAttribute('toolbar', $options['toolbar'])
            ->setAttribute('toolbar_groups', $options['toolbar_groups'])
            ->setAttribute('ui_color', $options['ui_color'] ? '#'.ltrim($options['ui_color'], '#') : null)
            ->setAttribute('startup_outline_blocks', $options['startup_outline_blocks'])
            ->setAttribute('width', $options['width'])
            ->setAttribute('height', $options['height'])
            ->setAttribute('force_paste_as_plaintext', $options['force_paste_as_plaintext'])
            ->setAttribute('language', $options['language'])
            ->setAttribute('filebrowser_browse_url', $options['filebrowser_browse_url'])
            ->setAttribute('filebrowser_upload_url', $options['filebrowser_upload_url'])
            ->setAttribute('filebrowser_image_browse_url', $options['filebrowser_image_browse_url'])
            ->setAttribute('filebrowser_image_upload_url', $options['filebrowser_image_upload_url'])
            ->setAttribute('filebrowser_flash_browse_url', $options['filebrowser_flash_browse_url'])
            ->setAttribute('filebrowser_flash_upload_url', $options['filebrowser_flash_upload_url'])
            ->setAttribute('skin', $options['skin'])
            ->setAttribute('disable_native_spell_checker', $options['disable_native_spell_checker'])
            ->setAttribute('format_tags', $options['format_tags'])
            ->setAttribute('base_path', $options['base_path'])
            ->setAttribute('base_href', $options['base_href'])
            ->setAttribute('body_class', $options['body_class'])
            ->setAttribute('contents_css', $options['contents_css'])
            ->setAttribute('basic_entities', $options['basic_entities'])
            ->setAttribute('entities', $options['entities'])
            ->setAttribute('entities_latin', $options['entities_latin'])
            ->setAttribute('startup_mode', $options['startup_mode'])
            ->setAttribute('enter_mode', $options['enter_mode'])
            ->setAttribute('templates_files', $options['templates_files'])
            ->setAttribute('allowed_content', $options['allowed_content'])
            ->setAttribute('extra_allowed_content', $options['extra_allowed_content'])
            ->setAttribute('templates_replace_content', $options['templates_replace_content'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $options['toolbar_groups'] = array_merge($this->container->getParameter('trsteel_ckeditor.ckeditor.toolbar_groups'), $options['toolbar_groups']);

        if (!is_array($options['toolbar_groups']) || count($options['toolbar_groups']) < 1) {
            throw new \Exception('You must supply at least 1 toolbar group.');
        }

        $toolbar_groups_keys = array_keys($options['toolbar_groups']);

        $toolbar = array();
        foreach ($options['toolbar'] as $toolbar_id) {
            if ('/' == $toolbar_id) {
                $toolbar[] = $toolbar_id;
            } else {
                if (!in_array($toolbar_id, $toolbar_groups_keys, true)) {
                    throw new \Exception('The toolbar "'.$toolbar_id.'" does not exist. Known options are '.implode(', ', $toolbar_groups_keys));
                }

                $toolbar[] = array(
                    'name' => $toolbar_id,
                    'items' => $options['toolbar_groups'][$toolbar_id],
                );
            }
        }

        $view->vars['toolbar'] = $toolbar;
        $view->vars['startup_outline_blocks'] = $options['startup_outline_blocks'];
        $view->vars['ui_color'] = $options['ui_color'];
        $view->vars['width'] = $options['width'];
        $view->vars['height'] = $options['height'];
        $view->vars['force_paste_as_plaintext'] = $options['force_paste_as_plaintext'];
        $view->vars['language'] = $options['language'];
        $view->vars['filebrowser_browse_url'] = $options['filebrowser_browse_url'];
        $view->vars['filebrowser_upload_url'] = $options['filebrowser_upload_url'];
        $view->vars['filebrowser_image_browse_url'] = $options['filebrowser_image_browse_url'];
        $view->vars['filebrowser_image_upload_url'] = $options['filebrowser_image_upload_url'];
        $view->vars['filebrowser_flash_browse_url'] = $options['filebrowser_flash_browse_url'];
        $view->vars['filebrowser_flash_upload_url'] = $options['filebrowser_flash_upload_url'];
        $view->vars['skin'] = $options['skin'];
        $view->vars['disable_native_spell_checker'] = $options['disable_native_spell_checker'];
        $view->vars['format_tags'] = $options['format_tags'];
        $view->vars['base_path'] = $options['base_path'];
        $view->vars['base_href'] = $options['base_href'];
        $view->vars['body_class'] = $options['body_class'];
        $view->vars['contents_css'] = $options['contents_css'];
        $view->vars['basic_entities'] = $options['basic_entities'];
        $view->vars['entities'] = $options['entities'];
        $view->vars['entities_latin'] = $options['entities_latin'];
        $view->vars['startup_mode'] = $options['startup_mode'];
        $view->vars['enter_mode'] = $options['enter_mode'];
        $view->vars['external_plugins'] = $options['external_plugins'];
        $view->vars['custom_config'] = $options['custom_config'];
        $view->vars['templates_files'] = $options['templates_files'];
        $view->vars['allowed_content'] = $options['allowed_content'];
        $view->vars['extra_allowed_content'] = $options['extra_allowed_content'];
        $view->vars['templates_replace_content'] = $options['templates_replace_content'];
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'required' => false,
            'transformers' => $this->container->getParameter('trsteel_ckeditor.ckeditor.transformers'),
            'toolbar' => $this->container->getParameter('trsteel_ckeditor.ckeditor.toolbar'),
            'toolbar_groups' => $this->container->getParameter('trsteel_ckeditor.ckeditor.toolbar_groups'),
            'startup_outline_blocks' => $this->container->getParameter('trsteel_ckeditor.ckeditor.startup_outline_blocks'),
            'ui_color' => $this->container->getParameter('trsteel_ckeditor.ckeditor.ui_color'),
            'width' => $this->container->getParameter('trsteel_ckeditor.ckeditor.width'),
            'height' => $this->container->getParameter('trsteel_ckeditor.ckeditor.height'),
            'force_paste_as_plaintext' => $this->container->getParameter('trsteel_ckeditor.ckeditor.force_paste_as_plaintext'),
            'language' => $this->container->getParameter('trsteel_ckeditor.ckeditor.language'),
            'filebrowser_browse_url' => $this->container->getParameter('trsteel_ckeditor.ckeditor.filebrowser_browse_url'),
            'filebrowser_upload_url' => $this->container->getParameter('trsteel_ckeditor.ckeditor.filebrowser_upload_url'),
            'filebrowser_image_browse_url' => $this->container->getParameter('trsteel_ckeditor.ckeditor.filebrowser_image_browse_url'),
            'filebrowser_image_upload_url' => $this->container->getParameter('trsteel_ckeditor.ckeditor.filebrowser_image_upload_url'),
            'filebrowser_flash_browse_url' => $this->container->getParameter('trsteel_ckeditor.ckeditor.filebrowser_flash_browse_url'),
            'filebrowser_flash_upload_url' => $this->container->getParameter('trsteel_ckeditor.ckeditor.filebrowser_flash_upload_url'),
            'skin' => $this->container->getParameter('trsteel_ckeditor.ckeditor.skin'),
            'disable_native_spell_checker' => $this->container->getParameter('trsteel_ckeditor.ckeditor.disable_native_spell_checker'),
            'format_tags' => $this->container->getParameter('trsteel_ckeditor.ckeditor.format_tags'),
            'base_path' => $this->container->getParameter('trsteel_ckeditor.ckeditor.base_path'),
            'base_href' => $this->container->getParameter('trsteel_ckeditor.ckeditor.base_href'),
            'body_class' => $this->container->getParameter('trsteel_ckeditor.ckeditor.body_class'),
            'contents_css' => $this->container->getParameter('trsteel_ckeditor.ckeditor.contents_css'),
            'basic_entities' => $this->container->getParameter('trsteel_ckeditor.ckeditor.basic_entities'),
            'entities' => $this->container->getParameter('trsteel_ckeditor.ckeditor.entities'),
            'entities_latin' => $this->container->getParameter('trsteel_ckeditor.ckeditor.entities_latin'),
            'startup_mode' => $this->container->getParameter('trsteel_ckeditor.ckeditor.startup_mode'),
            'enter_mode' => $this->container->getParameter('trsteel_ckeditor.ckeditor.enter_mode'),
            'external_plugins' => $this->container->getParameter('trsteel_ckeditor.ckeditor.external_plugins'),
            'custom_config' => $this->container->getParameter('trsteel_ckeditor.ckeditor.custom_config'),
            'templates_files' => $this->container->getParameter('trsteel_ckeditor.ckeditor.templates_files'),
            'allowed_content' => $this->container->getParameter('trsteel_ckeditor.ckeditor.allowed_content'),
            'extra_allowed_content' => $this->container->getParameter('trsteel_ckeditor.ckeditor.extra_allowed_content'),
            'templates_replace_content' => $this->container->getParameter('trsteel_ckeditor.ckeditor.templates_replace_content'),
        ));

        $allowedValues = array(
            'required' => array(true, false),
            'startup_outline_blocks' => array(null, true, false),
            'force_paste_as_plaintext' => array(null, true, false),
            'disable_native_spell_checker' => array(null, true, false),
            'basic_entities' => array(null, true, false),
            'startup_mode' => array(null, 'wysiwyg', 'source'),
            'enter_mode' => array(null, 'ENTER_P', 'ENTER_BR', 'ENTER_DIV'),
        );

        $allowedTypes = array(
            'transformers' => 'array',
            'toolbar' => 'array',
            'toolbar_groups' => 'array',
            'format_tags' => 'array',
            'external_plugins' => 'array',
        );

        // BC: Remove version check when support for Symfony <2.6 is dropped.
        if (Kernel::VERSION_ID >= 20600) {
            foreach ($allowedValues as $option => $values) {
                $resolver->setAllowedValues($option, $values);
            }

            foreach ($allowedTypes as $option => $types) {
                $resolver->setAllowedTypes($option, $types);
            }
        } else {
            $resolver->setAllowedValues($allowedValues);
            $resolver->setAllowedTypes($allowedTypes);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        // Use the Fully Qualified Class Name if the method getBlockPrefix exists.
        if (method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
            return 'Symfony\Component\Form\Extension\Core\Type\TextareaType';
        }

        // BC - Remove this when support for Symfony <2.8 is dropped.
        return 'textarea';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ckeditor';
    }
}
