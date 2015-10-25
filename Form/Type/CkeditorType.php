<?php

namespace Trsteel\CkeditorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * CKEditor type.
 */
class CkeditorType extends AbstractType
{
    protected $parameters;
    protected $transformers;

    public function __construct($parameters)
    {
        $this->parameters = $parameters;
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

        $options['toolbar_groups'] = array_merge($this->parameters['toolbar_groups'], $options['toolbar_groups']);

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
            ->setAttribute('extra_allowed_content', $options['extra_allowed_content'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $options['toolbar_groups'] = array_merge($this->parameters['toolbar_groups'], $options['toolbar_groups']);

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
        $view->vars['extra_allowed_content'] = $options['extra_allowed_content'];
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'required' => false,
            'transformers' => $this->parameters['transformers'],
            'toolbar' => $this->parameters['toolbar'],
            'toolbar_groups' => $this->parameters['toolbar_groups'],
            'startup_outline_blocks' => $this->parameters['startup_outline_blocks'],
            'ui_color' => $this->parameters['ui_color'],
            'width' => $this->parameters['width'],
            'height' => $this->parameters['height'],
            'force_paste_as_plaintext' => $this->parameters['force_paste_as_plaintext'],
            'language' => $this->parameters['language'],
            'filebrowser_browse_url' => $this->parameters['filebrowser_browse_url'],
            'filebrowser_upload_url' => $this->parameters['filebrowser_upload_url'],
            'filebrowser_image_browse_url' => $this->parameters['filebrowser_image_browse_url'],
            'filebrowser_image_upload_url' => $this->parameters['filebrowser_image_upload_url'],
            'filebrowser_flash_browse_url' => $this->parameters['filebrowser_flash_browse_url'],
            'filebrowser_flash_upload_url' => $this->parameters['filebrowser_flash_upload_url'],
            'skin' => $this->parameters['skin'],
            'disable_native_spell_checker' => $this->parameters['disable_native_spell_checker'],
            'format_tags' => $this->parameters['format_tags'],
            'base_path' => $this->parameters['base_path'],
            'base_href' => $this->parameters['base_href'],
            'body_class' => $this->parameters['body_class'],
            'contents_css' => $this->parameters['contents_css'],
            'basic_entities' => $this->parameters['basic_entities'],
            'entities' => $this->parameters['entities'],
            'entities_latin' => $this->parameters['entities_latin'],
            'startup_mode' => $this->parameters['startup_mode'],
            'enter_mode' => $this->parameters['enter_mode'],
            'external_plugins' => $this->parameters['external_plugins'],
            'custom_config' => $this->parameters['custom_config'],
            'templates_files' => $this->parameters['templates_files'],
            'extra_allowed_content' => $this->parameters['extra_allowed_content'],
        ));

        $resolver->setAllowedValues(array(
            'required' => array(true, false),
            'startup_outline_blocks' => array(null, true, false),
            'force_paste_as_plaintext' => array(null, true, false),
            'disable_native_spell_checker' => array(null, true, false),
            'basic_entities' => array(null, true, false),
            'startup_mode' => array(null, 'wysiwyg', 'source'),
            'enter_mode' => array(null, 'ENTER_P', 'ENTER_BR', 'ENTER_DIV'),
        ));

        $resolver->setAllowedTypes(array(
            'transformers' => 'array',
            'toolbar' => 'array',
            'toolbar_groups' => 'array',
            'format_tags' => 'array',
            'external_plugins' => 'array',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'textarea';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ckeditor';
    }
}
