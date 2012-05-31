<?php

namespace Trsteel\CkeditorBundle\Tests\Form;

use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;
use Trsteel\CkeditorBundle\Form\Type\CkeditorType;
use Trsteel\CkeditorBundle\Form\Transformer\StripJS;
use Trsteel\CkeditorBundle\Form\Transformer\StripCSS;
use Trsteel\CkeditorBundle\Form\Transformer\StripComments;

class CkeditorTypeTest extends TypeTestCase
{
    protected static $kernel;
    protected static $container;
    
    public static function setUpBeforeClass()
    {
        self::$kernel = new \AppKernel('dev', true);
        self::$kernel->boot();

        self::$container = self::$kernel->getContainer();
    }

    public function get($serviceId)
    {
        return self::$kernel->getContainer()->get($serviceId);
    }
    
    public function setUp()
    {
        parent::setUp();

        $CkeditorType = new CkeditorType($this->get('service_container'));

        $CkeditorType->addTransformer(new StripJS(), 'strip_js');
        $CkeditorType->addTransformer(new StripCSS(), 'strip_css');
        $CkeditorType->addTransformer(new StripComments(), 'strip_comments');
        
        $this->factory->addType($CkeditorType);
    } 
    
    /**
     * Check the default required property
     */
    public function testDefaultRequired()
    {
        $form = $this->factory->create('ckeditor');
        $view = $form->createView();
        $required = $view->getVar('required');

        $this->assertFalse($required);
    }
    
    /**
     * Check the required property
     */
    public function testRequired()
    {
        $this->setExpectedException('Symfony\Component\OptionsResolver\Exception\InvalidOptionsException');
        
        $form = $this->factory->create('ckeditor', null, array(
            'required' => true
        ));
    }

    /**
     * Check the default toolbar property
     */
    public function testDefaultToolbar()
    {
        $form = $this->factory->create('ckeditor');
        $view = $form->createView();
        $toolbar = $view->getVar('toolbar');

        $this->assertEquals($toolbar, array(
            array(
                'name' => 'document',
                'items' => array(
                    'Source',
                    '-',
                    'Save',
                    '-',
                    'Templates',
                )
            ),
            array(
                'name' => 'clipboard',
                'items' => array(
                    'Cut',
                    'Copy',
                    'Paste',
                    'PasteText',
                    'PasteFromWord',
                    '-',
                    'Undo',
                    'Redo',
                )
            ),
            array(
                'name' => 'editing',
                'items' => array(
                    'Find',
                    'Replace',
                    '-',
                    'SelectAll',
                )
            ),
            '/',
            array(
                'name' => 'basicstyles',
                'items' => array(
                    'Bold',
                    'Italic',
                    'Underline',
                    'Strike',
                    'Subscript',
                    'Superscript',
                    '-',
                    'RemoveFormat',
                )
            ),
            array(
                'name' => 'paragraph',
                'items' => array(
                    'NumberedList',
                    'BulletedList',
                    '-',
                    'Outdent',
                    'Indent',
                    '-',
                    'JustifyLeft',
                    'JustifyCenter',
                    'JustifyRight',
                    'JustifyBlock',
                )
            ),
            array(
                'name' => 'links',
                'items' => array(
                    'Link',
                    'Unlink',
                    'Anchor',
                )
            ),
            '/',
            array(
                'name' => 'insert',
                'items' => array(
                    'Image',
                    'Flash',
                    'Table',
                    'HorizontalRule',
                )
            ),
            array(
                'name' => 'styles',
                'items' => array(
                    'Styles',
                    'Format',
                )
            ),
            array(
                'name' => 'tools',
                'items' => array(
                    'Maximize',
                    'ShowBlocks',
                )
            )
        ));
    }
    
    /**
     * Check the toolbar property
     */
    public function testToolbar()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'toolbar' => array(
                'document',
            ),
            'toolbar_groups' => array(
                'document' => array(
                    'Source'
                )
            )
        ));
        $view = $form->createView();
        $toolbar = $view->getVar('toolbar');
        
        $this->assertEquals($toolbar, array(
            array(
                'name'  => 'document',
                'items' => array(
                    'Source'
                )
            )
        ));
    }

    /**
     * Check default startup_outline_blocks property
     */
    public function testDefaultstartupOutlineBlocks()
    {
        $form = $this->factory->create('ckeditor');
        $view = $form->createView();
        $startup_outline_blocks = $view->getVar('startup_outline_blocks');
        
        $this->assertTrue($startup_outline_blocks);
    }

    /**
     * Checks startup_outline_blocks property
     */
    public function teststartupOutlineBlocks()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'startup_outline_blocks' => false
        ));
        
        $view = $form->createView();
        $startup_outline_blocks = $view->getVar('startup_outline_blocks');
        
        $this->assertFalse($startup_outline_blocks);
    }
    
    /**
     * Check default ui_color property
     */
    public function testDefaultUiColor()
    {
        $form = $this->factory->create('ckeditor');
        $view = $form->createView();
        $ui_color = $view->getVar('ui_color');
        
        $this->assertNull($ui_color);
    }

    /**
     * Checks ui_color property
     */
    public function testUiColor()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'ui_color' => '#333333'
        ));
        
        $view = $form->createView();
        $ui_color = $view->getVar('ui_color');
        
        $this->assertEquals($ui_color, '#333333');
    }
    
    /**
     * Check default width property
     */
    public function testDefaultWidth()
    {
        $form = $this->factory->create('ckeditor');
        $view = $form->createView();
        $width = $view->getVar('width');
        
        $this->assertNull($width);
    }

    /**
     * Checks width property
     */
    public function testWidth()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'width' => '100%'
        ));
        
        $view = $form->createView();
        $width = $view->getVar('width');
        
        $this->assertEquals($width, '100%');
    }
    
    /**
     * Check default height property
     */
    public function testDefaultHeight()
    {
        $form = $this->factory->create('ckeditor');
        $view = $form->createView();
        $height = $view->getVar('height');
        
        $this->assertNull($height);
    }

    /**
     * Checks height property
     */
    public function testHeight()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'height' => '350px'
        ));
        
        $view = $form->createView();
        $height = $view->getVar('height');
        
        $this->assertEquals($height, '350px');
    }

    /**
     * Check default language property
     */
    public function testDefaultLanguage()
    {
        $form = $this->factory->create('ckeditor');
        $view = $form->createView();
        $language = $view->getVar('language');
        
        $this->assertNull($language);
    }

    /**
     * Checks language property
     */
    public function testLanguage()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'language' => 'en-au'
        ));
        
        $view = $form->createView();
        $language = $view->getVar('language');
        
        $this->assertEquals($language, 'en-au');
    }


    /**
     * Checks filebrowserBrowseUrl property
     */
    public function testFilebrowserBrowseUrl()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'filebrowser_browse_url' => '/myfilebrowser/browser.html'
        ));
        
        $view = $form->createView();
        $filebrowserBrowseUrl = $view->getVar('filebrowser_browse_url');
        
        $this->assertEquals($filebrowserBrowseUrl, '/myfilebrowser/browser.html');
    }

    /**
     * Checks filebrowserUploadUrl property
     */
    public function testFilebrowserUploadUrl()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'filebrowser_upload_url' => '/myfilebrowser/uploads'
        ));
        
        $view = $form->createView();
        $filebrowserUploadUrl = $view->getVar('filebrowser_upload_url');
        
        $this->assertEquals($filebrowserUploadUrl, '/myfilebrowser/uploads');
    }

    /**
     * Checks filebrowserImageBrowseUrl property
     */
    public function testFilebrowserImageBrowseUrl()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'filebrowser_image_browse_url' => '/myfilebrowser/browser.html'
        ));
        
        $view = $form->createView();
        $filebrowserImageBrowseUrl = $view->getVar('filebrowser_image_browse_url');
        
        $this->assertEquals($filebrowserImageBrowseUrl, '/myfilebrowser/browser.html');
    }

    /**
     * Checks filebrowserImageUploadUrl property
     */
    public function testFilebrowserImageUploadUrl()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'filebrowser_image_upload_url' => '/myfilebrowser/uploads'
        ));
        
        $view = $form->createView();
        $filebrowserImageUploadUrl = $view->getVar('filebrowser_image_upload_url');
        
        $this->assertEquals($filebrowserImageUploadUrl, '/myfilebrowser/uploads');
    }

    /**
     * Checks filebrowserFlashBrowseUrl property
     */
    public function testFilebrowserFlashBrowseUrl()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'filebrowser_flash_browse_url' => '/myfilebrowser/browser.html'
        ));
        
        $view = $form->createView();
        $filebrowserFlashBrowseUrl = $view->getVar('filebrowser_flash_browse_url');
        
        $this->assertEquals($filebrowserFlashBrowseUrl, '/myfilebrowser/browser.html');
    }

    /**
     * Checks filebrowserFlashUploadUrl property
     */
    public function testFilebrowserFlashUploadUrl()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'filebrowser_flash_upload_url' => '/myfilebrowser/uploads',
        ));
        
        $view = $form->createView();
        $filebrowserFlashUploadUrl = $view->getVar('filebrowser_flash_upload_url');
        
        $this->assertEquals($filebrowserFlashUploadUrl, '/myfilebrowser/uploads');
    }
	
	/**
     * Checks skin property
     */
    public function testSkin()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'skin' => 'myskin,/skins/myskin/',
        ));
        
        $view = $form->createView();
        $skin = $view->getVar('skin');
        
        $this->assertEquals($skin, 'myskin,/skins/myskin/');
    }

    /**
     * Checks format_tags property
     */
    public function testFormatTags()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'format_tags' => array('p','h2','h3','pre')
        ));

        $view = $form->createView();
        $skin = $view->getVar('format_tags');

        $this->assertEquals($skin, array('p','h2','h3','pre'));
    }
}