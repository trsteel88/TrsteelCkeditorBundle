<?php

namespace Trsteel\CkeditorBundle\Tests\Form;

use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\Forms;
use Trsteel\CkeditorBundle\Form\Type\CkeditorType;
use Trsteel\CkeditorBundle\Tests\AppKernel;

class CkeditorTypeTest extends TypeTestCase
{
    protected static $kernel;
    protected static $container;

    public static function setUpBeforeClass()
    {
        self::$kernel = new AppKernel('dev', true);
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

        $ckeditorType = new CkeditorType($this->get('service_container'));

        $this->factory = Forms::createFormFactoryBuilder()
            ->addType($ckeditorType)
            ->getFormFactory();
    }

    /**
     * Check the default required property
     */
    public function testDefaultRequired()
    {
        $form = $this->factory->create('ckeditor');
        $view = $form->createView();
        $required = $view->vars['required'];

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
        $toolbar = $view->vars['toolbar'];

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
        $toolbar = $view->vars['toolbar'];

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
        $startup_outline_blocks = $view->vars['startup_outline_blocks'];

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
        $startup_outline_blocks = $view->vars['startup_outline_blocks'];

        $this->assertFalse($startup_outline_blocks);
    }

    /**
     * Check default ui_color property
     */
    public function testDefaultUiColor()
    {
        $form = $this->factory->create('ckeditor');
        $view = $form->createView();
        $ui_color = $view->vars['ui_color'];

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
        $ui_color = $view->vars['ui_color'];

        $this->assertEquals($ui_color, '#333333');
    }

    /**
     * Check default width property
     */
    public function testDefaultWidth()
    {
        $form = $this->factory->create('ckeditor');
        $view = $form->createView();
        $width = $view->vars['width'];

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
        $width = $view->vars['width'];

        $this->assertEquals($width, '100%');
    }

    /**
     * Check default height property
     */
    public function testDefaultHeight()
    {
        $form = $this->factory->create('ckeditor');
        $view = $form->createView();
        $height = $view->vars['height'];

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
        $height = $view->vars['height'];

        $this->assertEquals($height, '350px');
    }

    /**
     * Check default language property
     */
    public function testDefaultLanguage()
    {
        $form = $this->factory->create('ckeditor');
        $view = $form->createView();
        $language = $view->vars['language'];

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
        $language = $view->vars['language'];

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
        $filebrowserBrowseUrl = $view->vars['filebrowser_browse_url'];

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
        $filebrowserUploadUrl = $view->vars['filebrowser_upload_url'];

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
        $filebrowserImageBrowseUrl = $view->vars['filebrowser_image_browse_url'];

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
        $filebrowserImageUploadUrl = $view->vars['filebrowser_image_upload_url'];

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
        $filebrowserFlashBrowseUrl = $view->vars['filebrowser_flash_browse_url'];

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
        $filebrowserFlashUploadUrl = $view->vars['filebrowser_flash_upload_url'];

        $this->assertEquals($filebrowserFlashUploadUrl, '/myfilebrowser/uploads');
    }

    /**
     * Checks filebrowserBrowseUrl property
     */
    public function testFilebrowserBrowseUrlRoute()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'filebrowser_browse_url' => array(
                'route' => 'file_browser',
                'route_parameters' => array(
                    'type' => 'file',
                ),
            )
        ));

        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_browse_url'];

        $this->assertEquals($filebrowserBrowseUrl, array(
            'route' => 'file_browser',
            'route_parameters' => array(
                'type' => 'file',
            ),
        ));
    }

    /**
     * Checks filebrowserUploadUrl property
     */
    public function testFilebrowserUploadUrlRoute()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'filebrowser_upload_url' => array(
                'route' => 'file_browser_upload',
                'route_parameters' => array(
                    'type' => 'file',
                ),
            )
        ));

        $view = $form->createView();
        $filebrowserUploadUrl = $view->vars['filebrowser_upload_url'];

        $this->assertEquals($filebrowserUploadUrl, array(
            'route' => 'file_browser_upload',
            'route_parameters' => array(
                'type' => 'file',
            ),
        ));
    }

    /**
     * Checks filebrowserImageBrowseUrl property
     */
    public function testFilebrowserImageBrowseUrlRoute()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'filebrowser_image_browse_url' => array(
                'route' => 'file_browser',
                'route_parameters' => array(
                    'type' => 'image',
                ),
            )
        ));

        $view = $form->createView();
        $filebrowserImageBrowseUrl = $view->vars['filebrowser_image_browse_url'];

        $this->assertEquals($filebrowserImageBrowseUrl, array(
            'route' => 'file_browser',
            'route_parameters' => array(
                'type' => 'image',
            ),
        ));
    }

    /**
     * Checks filebrowserImageUploadUrl property
     */
    public function testFilebrowserImageUploadUrlRoute()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'filebrowser_image_upload_url' => array(
                'route' => 'file_browser_upload',
                'route_parameters' => array(
                    'type' => 'image',
                ),
            )
        ));

        $view = $form->createView();
        $filebrowserImageUploadUrl = $view->vars['filebrowser_image_upload_url'];

        $this->assertEquals($filebrowserImageUploadUrl, array(
            'route' => 'file_browser_upload',
            'route_parameters' => array(
                'type' => 'image',
            ),
        ));
    }

    /**
     * Checks filebrowserFlashBrowseUrl property
     */
    public function testFilebrowserFlashBrowseUrlRoute()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'filebrowser_flash_browse_url' => array(
                'route' => 'file_browser',
                'route_parameters' => array(
                    'type' => 'flash',
                ),
            )
        ));

        $view = $form->createView();
        $filebrowserFlashBrowseUrl = $view->vars['filebrowser_flash_browse_url'];

        $this->assertEquals($filebrowserFlashBrowseUrl, array(
            'route' => 'file_browser',
            'route_parameters' => array(
                'type' => 'flash',
            ),
        ));
    }

    /**
     * Checks filebrowserFlashUploadUrl property
     */
    public function testFilebrowserFlashUploadUrlRoute()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'filebrowser_flash_upload_url' => array(
                'route' => 'file_browser_upload',
                'route_parameters' => array(
                    'type' => 'flash',
                ),
            ),
        ));

        $view = $form->createView();
        $filebrowserFlashUploadUrl = $view->vars['filebrowser_flash_upload_url'];

        $this->assertEquals($filebrowserFlashUploadUrl, array(
            'route' => 'file_browser_upload',
            'route_parameters' => array(
                'type' => 'flash',
            ),
        ));
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
        $skin = $view->vars['skin'];

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
        $formatTags = $view->vars['format_tags'];

        $this->assertEquals($formatTags, array('p','h2','h3','pre'));
    }

    /**
     * Checks base_path property
     */
    public function testBasePath()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'base_path' => '/lib/ckeditor/',
        ));

        $view = $form->createView();
        $basePath = $view->vars['base_path'];

        $this->assertEquals($basePath, '/lib/ckeditor/');
    }

    /**
     * Checks base_href property
     */
    public function testBaseHref()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'base_href' => 'http://domain.com/',
        ));

        $view = $form->createView();
        $baseHref = $view->vars['base_href'];

        $this->assertEquals($baseHref, 'http://domain.com/');
    }

    /**
     * Checks body_class property
     */
    public function testBodyClass()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'body_class' => 'special_class',
        ));

        $view = $form->createView();
        $bodyClass = $view->vars['body_class'];

        $this->assertEquals($bodyClass, 'special_class');
    }

    /**
     * Checks contents_css property
     */
    public function testContentsCssAsArray()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'contents_css' => array(
                '/css/ckeditor/contents1.css',
                '/css/ckeditor/contents2.css',
            ),
        ));

        $view = $form->createView();
        $contentsCss = $view->vars['contents_css'];

        $this->assertEquals($contentsCss, array(
            '/css/ckeditor/contents1.css',
            '/css/ckeditor/contents2.css',
        ));
    }

    /**
     * Checks contents_css property as a string
     */
    public function testContentsCssAsString()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'contents_css' => '/css/ckeditor/contents.css',
        ));

        $view = $form->createView();
        $contentsCss = $view->vars['contents_css'];

        $this->assertEquals($contentsCss, '/css/ckeditor/contents.css');
    }

    /**
     * Checks basic_entities property
     */
    public function testBasicEntities()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'basic_entities' => false,
        ));

        $view = $form->createView();
        $basicEntities = $view->vars['basic_entities'];

        $this->assertEquals($basicEntities, false);
    }

    /**
     * Checks entities property
     */
    public function testEntities()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'entities' => false,
        ));

        $view = $form->createView();
        $entities = $view->vars['entities'];

        $this->assertEquals($entities, false);
    }

    /**
     * Checks entities_latin property
     */
    public function testEntitiesLatin()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'entities_latin' => false,
        ));

        $view = $form->createView();
        $entitiesLatin = $view->vars['entities_latin'];

        $this->assertEquals($entitiesLatin, false);
    }

    /**
     * Checks startup_mode property
     */
    public function testStartupMode()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'startup_mode' => 'source',
        ));

        $view = $form->createView();
        $startupMode = $view->vars['startup_mode'];

        $this->assertEquals($startupMode, 'source');
    }

    /**
     * Checks external_plugins property
     */
    public function testExternalPlugins()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'external_plugins' => array(
                'my_custom_plugin' => array(
                    'path' => 'js/ckeditor/plugins/my_custom_plugin',
                    'file' => 'plugin.js',
                ),
            ),
        ));
        $view = $form->createView();
        $externalPlugins = $view->vars['external_plugins'];

        $this->assertEquals($externalPlugins, array(
            'my_custom_plugin' => array(
                'path' => 'js/ckeditor/plugins/my_custom_plugin',
                'file' => 'plugin.js',
            ),
        ));
    }

    /**
     * Check default customConfig property
     */
    public function testDefaultCustomConfig()
    {
        $form = $this->factory->create('ckeditor');
        $view = $form->createView();
        $customConfig = $view->vars['custom_config'];

        $this->assertNull($customConfig);
    }

    /**
     * Checks customConfig property
     */
    public function testCustomConfig()
    {
        $form = $this->factory->create('ckeditor', null, array(
            'custom_config' => 'someconfig.js'
        ));

        $view = $form->createView();
        $customConfig = $view->vars['custom_config'];

        $this->assertEquals($customConfig, 'someconfig.js');
    }
}
