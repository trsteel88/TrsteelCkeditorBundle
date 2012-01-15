<?php

namespace Trsteel\CkeditorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * CKEditor type
 *
 */
class CkeditorType extends AbstractType
{
	protected $container;
	
	public function __construct(Container $container)
	{
		$this->container = $container;		
	}
	
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
		$default_toolbar_groups = $this->getDefaultOptions(array());
		$default_toolbar_groups = $default_toolbar_groups['toolbar_groups'];
		
        $builder
            ->setAttribute('toolbar', $options['toolbar'])
            ->setAttribute('toolbar_groups', array_merge($default_toolbar_groups, $options['toolbar_groups']))
            ->setAttribute('uiColor', $options['uiColor'] ? '#'.ltrim($options['uiColor'], '#') : null)
            ->setAttribute('startupOutlineBlocks', $options['startupOutlineBlocks'])
            ->setAttribute('width', $options['width'])
            ->setAttribute('height', $options['height'])
		;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form)
    {
		if(!is_array($form->getAttribute('toolbar_groups')) || count($form->getAttribute('toolbar_groups')) < 1){
			throw new \Exception('You must supply at least 1 toolbar group.');
		}
		
		$toolbar_groups = $form->getAttribute('toolbar_groups');
		$toolbar_groups_keys = array_keys($toolbar_groups);
		
		$toolbar = array();
		foreach($form->getAttribute('toolbar') as $toolbar_id){
			if("/" == $toolbar_id){
				$toolbar[] = $toolbar_id;
			}
			else {	
				if(!in_array($toolbar_id, $toolbar_groups_keys, true)){
					throw new \Exception('The toolbar "'.$toolbar_id.'" does not exist. Known options are '. implode(", ", $toolbar_groups_keys));
				}

				$toolbar[] = array(
					'name'	=> $toolbar_id,
					'items'	=> $toolbar_groups[$toolbar_id],
				);
			}
		}
	
        $view
            ->set('toolbar', $toolbar)
            ->set('startupOutlineBlocks', $form->getAttribute('startupOutlineBlocks'))
            ->set('uiColor', $form->getAttribute('uiColor'))
			->set('width', $form->getAttribute('width'))
			->set('height', $form->getAttribute('height'))
		;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options)
    {
        return array(
			'required'				=> false,
			'toolbar'				=> $this->container->getParameter('trsteel_ckeditor.ckeditor.toolbar'),
            'toolbar_groups' 		=> $this->container->getParameter('trsteel_ckeditor.ckeditor.toolbar_groups'),
			'startupOutlineBlocks'	=> $this->container->getParameter('trsteel_ckeditor.ckeditor.startupOutlineBlocks'),
            'uiColor' 				=> $this->container->getParameter('trsteel_ckeditor.ckeditor.uiColor'),
			'width'					=> $this->container->getParameter('trsteel_ckeditor.ckeditor.width'),
			'height'				=> $this->container->getParameter('trsteel_ckeditor.ckeditor.height'),
        );
    }
    
    /**
     * Returns the allowed option values for each option (if any).
     *
     * @param array $options
     *
     * @return array The allowed option values
     */
    public function getAllowedOptionValues(array $options)
    {
        return array(
			'required'				=> array(false),
			'startupOutlineBlocks'	=> array(true, false)
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
