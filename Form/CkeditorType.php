<?php

namespace Trsteel\CkeditorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * CKEditor type
 *
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
    public function buildForm(FormBuilder $builder, array $options)
    {
        foreach($options['transformers'] as $transformer_alias) {
            if (isset($this->transformers[$transformer_alias])) {
                $builder->appendClientTransformer($this->transformers[$transformer_alias]);
            } else {
                throw new \Exception(sprintf("'%s' is not a valid transformer.", $transformer_alias));
            }
        }

        $default_toolbar_groups = $this->getDefaultOptions();
        $default_toolbar_groups = array_merge($default_toolbar_groups['toolbar_groups'], $options['toolbar_groups']);
        
        $builder
            ->setAttribute('toolbar', $options['toolbar'])
            ->setAttribute('toolbar_groups', $default_toolbar_groups)
            ->setAttribute('ui_color', $options['ui_color'] ? '#'.ltrim($options['ui_color'], '#') : null)
            ->setAttribute('startup_outline_blocks', $options['startup_outline_blocks'])
            ->setAttribute('width', $options['width'])
            ->setAttribute('height', $options['height'])
            ->setAttribute('language', $options['language'])
            ->setAttribute('filebrowser_browse_url', $options['filebrowser_browse_url'])
            ->setAttribute('filebrowser_upload_url', $options['filebrowser_upload_url'])
            ->setAttribute('filebrowser_image_browse_url', $options['filebrowser_image_browse_url'])
            ->setAttribute('filebrowser_image_upload_url', $options['filebrowser_image_upload_url'])
            ->setAttribute('filebrowser_flash_browse_url', $options['filebrowser_flash_browse_url'])
            ->setAttribute('filebrowser_flash_upload_url', $options['filebrowser_flash_upload_url'])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form)
    {
        if (!is_array($form->getAttribute('toolbar_groups')) || count($form->getAttribute('toolbar_groups')) < 1) {
            throw new \Exception('You must supply at least 1 toolbar group.');
        }
        
        $toolbar_groups = $form->getAttribute('toolbar_groups');
        $toolbar_groups_keys = array_keys($toolbar_groups);
        
        $toolbar = array();
        foreach($form->getAttribute('toolbar') as $toolbar_id) {
            if ("/" == $toolbar_id) {
                $toolbar[] = $toolbar_id;
            }
            else {    
                if (!in_array($toolbar_id, $toolbar_groups_keys, true)) {
                    throw new \Exception('The toolbar "'.$toolbar_id.'" does not exist. Known options are '. implode(", ", $toolbar_groups_keys));
                }

                $toolbar[] = array(
                    'name'    => $toolbar_id,
                    'items'    => $toolbar_groups[$toolbar_id],
                );
            }
        }
    
        $view
            ->set('toolbar', $toolbar)
            ->set('startup_outline_blocks', $form->getAttribute('startup_outline_blocks'))
            ->set('ui_color', $form->getAttribute('ui_color'))
            ->set('width', $form->getAttribute('width'))
            ->set('height', $form->getAttribute('height'))
            ->set('language', $form->getAttribute('language'))
            ->set('filebrowser_browse_url', $form->getAttribute('filebrowser_browse_url'))
            ->set('filebrowser_upload_url', $form->getAttribute('filebrowser_upload_url'))
            ->set('filebrowser_image_browse_url', $form->getAttribute('filebrowser_image_browse_url'))
            ->set('filebrowser_image_upload_url', $form->getAttribute('filebrowser_image_upload_url'))
            ->set('filebrowser_flash_browse_url', $form->getAttribute('filebrowser_flash_browse_url'))
            ->set('filebrowser_flash_upload_url', $form->getAttribute('filebrowser_flash_upload_url'))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options = array())
    {
        return array(
            'required'                     => false,
            'transformers'                 => $this->container->getParameter('trsteel_ckeditor.ckeditor.transformers'),
            'toolbar'                      => $this->container->getParameter('trsteel_ckeditor.ckeditor.toolbar'),
            'toolbar_groups'               => $this->container->getParameter('trsteel_ckeditor.ckeditor.toolbar_groups'),
            'startup_outline_blocks'       => $this->container->getParameter('trsteel_ckeditor.ckeditor.startup_outline_blocks'),
            'ui_color'                     => $this->container->getParameter('trsteel_ckeditor.ckeditor.ui_color'),
            'width'                        => $this->container->getParameter('trsteel_ckeditor.ckeditor.width'),
            'height'                       => $this->container->getParameter('trsteel_ckeditor.ckeditor.height'),
            'language'                     => $this->container->getParameter('trsteel_ckeditor.ckeditor.language'),
            'filebrowser_browse_url'       => $this->container->getParameter('trsteel_ckeditor.ckeditor.filebrowser_browse_url'),
            'filebrowser_upload_url'       => $this->container->getParameter('trsteel_ckeditor.ckeditor.filebrowser_upload_url'),
            'filebrowser_image_browse_url' => $this->container->getParameter('trsteel_ckeditor.ckeditor.filebrowser_image_browse_url'),
            'filebrowser_image_upload_url' => $this->container->getParameter('trsteel_ckeditor.ckeditor.filebrowser_image_upload_url'),
            'filebrowser_flash_browse_url' => $this->container->getParameter('trsteel_ckeditor.ckeditor.filebrowser_flash_browse_url'),
            'filebrowser_flash_upload_url' => $this->container->getParameter('trsteel_ckeditor.ckeditor.filebrowser_flash_upload_url'),            
        );
    }
    
    /**
     * Returns the allowed option values for each option (if any).
     *
     * @param array $options
     *
     * @return array The allowed option values
     */
    public function getAllowedOptionValues(array $options = array())
    {
        return array(
            'required'               => array(false),
            'startup_outline_blocks' => array(true, false)
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
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
