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

    /**
     * @var \Symfony\Component\Form\FormFactoryInterface
     */
    protected $factory;

    /**
     * @var string
     */
    protected $formType;

    /**
     * {@inheritdooc}.
     */
    public static function setUpBeforeClass()
    {
        self::$kernel = new AppKernel('dev', true);
        self::$kernel->boot();

        self::$container = self::$kernel->getContainer();
    }

    /**
     * Get service from container by id.
     * 
     * @param string $serviceId
     *
     * @return mixed
     */
    public function get($serviceId)
    {
        return self::$kernel->getContainer()->get($serviceId);
    }

    /**
     * {@inheritdooc}.
     */
    public function setUp()
    {
        parent::setUp();

        $ckeditorType = new CkeditorType($this->get('service_container'));

        $this->factory = Forms::createFormFactoryBuilder()
            ->addType($ckeditorType)
            ->getFormFactory();

        $this->formType = method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix') ? 'Trsteel\CkeditorBundle\Form\Type\CkeditorType' : 'ckeditor';
    }

    /**
     * Check the default required property.
     */
    public function testDefaultRequired()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $required = $view->vars['required'];

        $this->assertFalse($required);
    }

    /**
     * Check the required property.
     */
    public function testRequired()
    {
        $form = $this->factory->create($this->formType, null, array(
            'required' => true,
        ));

        $view = $form->createView();
        $required = $view->vars['required'];

        $this->assertEquals($required, true);
    }

    /**
     * Check the default toolbar property.
     */
    public function testDefaultToolbar()
    {
        $form = $this->factory->create($this->formType);
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
                ),
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
                ),
            ),
            array(
                'name' => 'editing',
                'items' => array(
                    'Find',
                    'Replace',
                    '-',
                    'SelectAll',
                ),
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
                ),
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
                ),
            ),
            array(
                'name' => 'links',
                'items' => array(
                    'Link',
                    'Unlink',
                    'Anchor',
                ),
            ),
            '/',
            array(
                'name' => 'insert',
                'items' => array(
                    'Image',
                    'Flash',
                    'Table',
                    'HorizontalRule',
                ),
            ),
            array(
                'name' => 'styles',
                'items' => array(
                    'Styles',
                    'Format',
                ),
            ),
            array(
                'name' => 'tools',
                'items' => array(
                    'Maximize',
                    'ShowBlocks',
                ),
            ),
        ));
    }

    /**
     * Check the toolbar property.
     */
    public function testToolbar()
    {
        $form = $this->factory->create($this->formType, null, array(
            'toolbar' => array(
                'document',
            ),
            'toolbar_groups' => array(
                'document' => array(
                    'Source',
                ),
            ),
        ));
        $view = $form->createView();
        $toolbar = $view->vars['toolbar'];

        $this->assertEquals($toolbar, array(
            array(
                'name' => 'document',
                'items' => array(
                    'Source',
                ),
            ),
        ));
    }

    /**
     * Check default startup_outline_blocks property.
     */
    public function testDefaultStartupOutlineBlocks()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $startup_outline_blocks = $view->vars['startup_outline_blocks'];

        $this->assertTrue($startup_outline_blocks);
    }

    /**
     * Checks startup_outline_blocks property.
     */
    public function testStartupOutlineBlocks()
    {
        $form = $this->factory->create($this->formType, null, array(
            'startup_outline_blocks' => false,
        ));

        $view = $form->createView();
        $startup_outline_blocks = $view->vars['startup_outline_blocks'];

        $this->assertFalse($startup_outline_blocks);
    }

    /**
     * Check default ui_color property.
     */
    public function testDefaultUiColor()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $ui_color = $view->vars['ui_color'];

        $this->assertNull($ui_color);
    }

    /**
     * Checks ui_color property.
     */
    public function testUiColor()
    {
        $form = $this->factory->create($this->formType, null, array(
            'ui_color' => '#333333',
        ));

        $view = $form->createView();
        $ui_color = $view->vars['ui_color'];

        $this->assertEquals($ui_color, '#333333');
    }

    /**
     * Check default width property.
     */
    public function testDefaultWidth()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $width = $view->vars['width'];

        $this->assertNull($width);
    }

    /**
     * Checks width property.
     */
    public function testWidth()
    {
        $form = $this->factory->create($this->formType, null, array(
            'width' => '100%',
        ));

        $view = $form->createView();
        $width = $view->vars['width'];

        $this->assertEquals($width, '100%');
    }

    /**
     * Check default height property.
     */
    public function testDefaultHeight()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $height = $view->vars['height'];

        $this->assertNull($height);
    }

    /**
     * Checks height property.
     */
    public function testHeight()
    {
        $form = $this->factory->create($this->formType, null, array(
            'height' => '350px',
        ));

        $view = $form->createView();
        $height = $view->vars['height'];

        $this->assertEquals($height, '350px');
    }

    /**
     * Check default language property.
     */
    public function testDefaultLanguage()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $language = $view->vars['language'];

        $this->assertNull($language);
    }

    /**
     * Checks language property.
     */
    public function testLanguage()
    {
        $form = $this->factory->create($this->formType, null, array(
            'language' => 'en-au',
        ));

        $view = $form->createView();
        $language = $view->vars['language'];

        $this->assertEquals($language, 'en-au');
    }

    /**
     * Check the default filebrowserBrowseUrl property.
     */
    public function testDefaultFileBrowserBrowseUrl()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_browse_url'];

        $this->assertEquals($filebrowserBrowseUrl, array(
            'url' => null,
            'route' => null,
            'route_parameters' => array(),
        ));
    }

    /**
     * Checks filebrowserBrowseUrl property.
     */
    public function testFileBrowserBrowseUrl()
    {
        $form = $this->factory->create($this->formType, null, array(
            'filebrowser_browse_url' => '/myfilebrowser/browser.html',
        ));

        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_browse_url'];

        $this->assertEquals($filebrowserBrowseUrl, '/myfilebrowser/browser.html');
    }

    /**
     * Checks filebrowserBrowseUrl property.
     */
    public function testFileBrowserBrowseUrlRoute()
    {
        $form = $this->factory->create($this->formType, null, array(
            'filebrowser_browse_url' => array(
                'route' => 'file_browser',
                'route_parameters' => array(
                    'type' => 'file',
                ),
            ),
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
     * Check the default filebrowserUploadUrl property.
     */
    public function testDefaultFileBrowserUploadUrl()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_upload_url'];

        $this->assertEquals($filebrowserBrowseUrl, array(
            'url' => null,
            'route' => null,
            'route_parameters' => array(),
        ));
    }

    /**
     * Checks filebrowserUploadUrl property.
     */
    public function testFileBrowserUploadUrl()
    {
        $form = $this->factory->create($this->formType, null, array(
            'filebrowser_upload_url' => '/myfilebrowser/uploads',
        ));

        $view = $form->createView();
        $filebrowserUploadUrl = $view->vars['filebrowser_upload_url'];

        $this->assertEquals($filebrowserUploadUrl, '/myfilebrowser/uploads');
    }

    /**
     * Checks filebrowserUploadUrl property.
     */
    public function testFileBrowserUploadUrlRoute()
    {
        $form = $this->factory->create($this->formType, null, array(
            'filebrowser_upload_url' => array(
                'route' => 'file_browser_upload',
                'route_parameters' => array(
                    'type' => 'file',
                ),
            ),
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
     * Check the default filebrowserImageBrowseUrl property.
     */
    public function testDefaultFileBrowserImageBrowseUrl()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_image_browse_url'];

        $this->assertEquals($filebrowserBrowseUrl, array(
            'url' => null,
            'route' => null,
            'route_parameters' => array(),
        ));
    }

    /**
     * Checks filebrowserImageBrowseUrl property.
     */
    public function testFileBrowserImageBrowseUrl()
    {
        $form = $this->factory->create($this->formType, null, array(
            'filebrowser_image_browse_url' => '/myfilebrowser/browser.html',
        ));

        $view = $form->createView();
        $filebrowserImageBrowseUrl = $view->vars['filebrowser_image_browse_url'];

        $this->assertEquals($filebrowserImageBrowseUrl, '/myfilebrowser/browser.html');
    }

    /**
     * Checks filebrowserImageBrowseUrl property.
     */
    public function testFileBrowserImageBrowseUrlRoute()
    {
        $form = $this->factory->create($this->formType, null, array(
            'filebrowser_image_browse_url' => array(
                'route' => 'file_browser',
                'route_parameters' => array(
                    'type' => 'image',
                ),
            ),
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
     * Check the default filebrowserImageUploadUrl property.
     */
    public function testDefaultFileBrowserImageUploadUrl()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_image_upload_url'];

        $this->assertEquals($filebrowserBrowseUrl, array(
            'url' => null,
            'route' => null,
            'route_parameters' => array(),
        ));
    }

    /**
     * Checks filebrowserImageUploadUrl property.
     */
    public function testFileBrowserImageUploadUrl()
    {
        $form = $this->factory->create($this->formType, null, array(
            'filebrowser_image_upload_url' => '/myfilebrowser/uploads',
        ));

        $view = $form->createView();
        $filebrowserImageUploadUrl = $view->vars['filebrowser_image_upload_url'];

        $this->assertEquals($filebrowserImageUploadUrl, '/myfilebrowser/uploads');
    }

    /**
     * Checks filebrowserImageUploadUrl property.
     */
    public function testFileBrowserImageUploadUrlRoute()
    {
        $form = $this->factory->create($this->formType, null, array(
            'filebrowser_image_upload_url' => array(
                'route' => 'file_browser_upload',
                'route_parameters' => array(
                    'type' => 'image',
                ),
            ),
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
     * Check the default filebrowserFlashBrowseUrl property.
     */
    public function testDefaultFileBrowserFlashBrowseUrl()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_flash_browse_url'];

        $this->assertEquals($filebrowserBrowseUrl, array(
            'url' => null,
            'route' => null,
            'route_parameters' => array(),
        ));
    }

    /**
     * Checks filebrowserFlashBrowseUrl property.
     */
    public function testFileBrowserFlashBrowseUrl()
    {
        $form = $this->factory->create($this->formType, null, array(
            'filebrowser_flash_browse_url' => '/myfilebrowser/browser.html',
        ));

        $view = $form->createView();
        $filebrowserFlashBrowseUrl = $view->vars['filebrowser_flash_browse_url'];

        $this->assertEquals($filebrowserFlashBrowseUrl, '/myfilebrowser/browser.html');
    }

    /**
     * Checks filebrowserFlashBrowseUrl property.
     */
    public function testFileBrowserFlashBrowseUrlRoute()
    {
        $form = $this->factory->create($this->formType, null, array(
            'filebrowser_flash_browse_url' => array(
                'route' => 'file_browser',
                'route_parameters' => array(
                    'type' => 'flash',
                ),
            ),
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
     * Check the default filebrowserFlashUploadUrl property.
     */
    public function testDefaultFileBrowserFlashUploadUrl()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_flash_upload_url'];

        $this->assertEquals($filebrowserBrowseUrl, array(
            'url' => null,
            'route' => null,
            'route_parameters' => array(),
        ));
    }

    /**
     * Checks filebrowserFlashUploadUrl property.
     */
    public function testFileBrowserFlashUploadUrl()
    {
        $form = $this->factory->create($this->formType, null, array(
            'filebrowser_flash_upload_url' => '/myfilebrowser/uploads',
        ));

        $view = $form->createView();
        $filebrowserFlashUploadUrl = $view->vars['filebrowser_flash_upload_url'];

        $this->assertEquals($filebrowserFlashUploadUrl, '/myfilebrowser/uploads');
    }

    /**
     * Checks filebrowserFlashUploadUrl property.
     */
    public function testFileBrowserFlashUploadUrlRoute()
    {
        $form = $this->factory->create($this->formType, null, array(
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
     * Check default skin property.
     */
    public function testDefaultSkin()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $skin = $view->vars['skin'];

        $this->assertNull($skin);
    }

    /**
     * Checks skin property.
     */
    public function testSkin()
    {
        $form = $this->factory->create($this->formType, null, array(
            'skin' => 'myskin,/skins/myskin/',
        ));

        $view = $form->createView();
        $skin = $view->vars['skin'];

        $this->assertEquals($skin, 'myskin,/skins/myskin/');
    }

    /**
     * Check default disableNativeSpellChecker property.
     */
    public function testDefaultDisableNativeSpellChecker()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $disableNativeSpellChecker = $view->vars['disable_native_spell_checker'];

        $this->assertNull($disableNativeSpellChecker);
    }

    /**
     * Checks disableNativeSpellChecker property.
     */
    public function testDisableNativeSpellChecker()
    {
        $form = $this->factory->create($this->formType, null, array(
            'disable_native_spell_checker' => true,
        ));

        $view = $form->createView();
        $disableNativeSpellChecker = $view->vars['disable_native_spell_checker'];

        $this->assertTrue($disableNativeSpellChecker);
    }

    /**
     * Check default format_tags property.
     */
    public function testDefaultFormatTags()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $formatTags = $view->vars['format_tags'];

        $this->assertEquals($formatTags, array());
    }

    /**
     * Checks format_tags property.
     */
    public function testFormatTags()
    {
        $form = $this->factory->create($this->formType, null, array(
            'format_tags' => array('p', 'h2', 'h3', 'pre'),
        ));

        $view = $form->createView();
        $formatTags = $view->vars['format_tags'];

        $this->assertEquals($formatTags, array('p', 'h2', 'h3', 'pre'));
    }

    /**
     * Check default base_path property.
     */
    public function testDefaultBasePath()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $basePath = $view->vars['base_path'];

        $this->assertEquals($basePath, 'bundles/trsteelckeditor/');
    }

    /**
     * Checks base_path property.
     */
    public function testBasePath()
    {
        $form = $this->factory->create($this->formType, null, array(
            'base_path' => '/lib/ckeditor/',
        ));

        $view = $form->createView();
        $basePath = $view->vars['base_path'];

        $this->assertEquals($basePath, '/lib/ckeditor/');
    }

    /**
     * Check default base_href property.
     */
    public function testDefaultBaseHref()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $baseHref = $view->vars['base_href'];

        $this->assertNull($baseHref);
    }

    /**
     * Checks base_href property.
     */
    public function testBaseHref()
    {
        $form = $this->factory->create($this->formType, null, array(
            'base_href' => 'http://domain.com/',
        ));

        $view = $form->createView();
        $baseHref = $view->vars['base_href'];

        $this->assertEquals($baseHref, 'http://domain.com/');
    }

    /**
     * Check default body_class property.
     */
    public function testDefaultBodyClass()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $bodyClass = $view->vars['body_class'];

        $this->assertNull($bodyClass);
    }

    /**
     * Checks body_class property.
     */
    public function testBodyClass()
    {
        $form = $this->factory->create($this->formType, null, array(
            'body_class' => 'special_class',
        ));

        $view = $form->createView();
        $bodyClass = $view->vars['body_class'];

        $this->assertEquals($bodyClass, 'special_class');
    }

    /**
     * Check default contents_css property.
     */
    public function testDefaultContentsCss()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $contentsCss = $view->vars['contents_css'];

        $this->assertEquals($contentsCss, array());
    }

    /**
     * Checks contents_css property.
     */
    public function testContentsCssAsArray()
    {
        $form = $this->factory->create($this->formType, null, array(
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
     * Checks contents_css property as a string.
     */
    public function testContentsCssAsString()
    {
        $form = $this->factory->create($this->formType, null, array(
            'contents_css' => '/css/ckeditor/contents.css',
        ));

        $view = $form->createView();
        $contentsCss = $view->vars['contents_css'];

        $this->assertEquals($contentsCss, '/css/ckeditor/contents.css');
    }

    /**
     * Check default basic_entities property.
     */
    public function testDefaultBasicEntities()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $basicEntities = $view->vars['basic_entities'];

        $this->assertNull($basicEntities);
    }

    /**
     * Checks basic_entities property.
     */
    public function testBasicEntities()
    {
        $form = $this->factory->create($this->formType, null, array(
            'basic_entities' => false,
        ));

        $view = $form->createView();
        $basicEntities = $view->vars['basic_entities'];

        $this->assertEquals($basicEntities, false);
    }

    /**
     * Check default entities property.
     */
    public function testDefaultEntities()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $entities = $view->vars['entities'];

        $this->assertNull($entities);
    }

    /**
     * Checks entities property.
     */
    public function testEntities()
    {
        $form = $this->factory->create($this->formType, null, array(
            'entities' => false,
        ));

        $view = $form->createView();
        $entities = $view->vars['entities'];

        $this->assertEquals($entities, false);
    }

    /**
     * Check default entities_latin property.
     */
    public function testDefaultEntitiesLatin()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $entitiesLatin = $view->vars['entities_latin'];

        $this->assertNull($entitiesLatin);
    }

    /**
     * Checks entities_latin property.
     */
    public function testEntitiesLatin()
    {
        $form = $this->factory->create($this->formType, null, array(
            'entities_latin' => false,
        ));

        $view = $form->createView();
        $entitiesLatin = $view->vars['entities_latin'];

        $this->assertEquals($entitiesLatin, false);
    }

    /**
     * Check default startup_mode property.
     */
    public function testDefaultStartupMode()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $startupMode = $view->vars['startup_mode'];

        $this->assertNull($startupMode);
    }

    /**
     * Checks startup_mode property.
     */
    public function testStartupMode()
    {
        $form = $this->factory->create($this->formType, null, array(
            'startup_mode' => 'source',
        ));

        $view = $form->createView();
        $startupMode = $view->vars['startup_mode'];

        $this->assertEquals($startupMode, 'source');
    }

    /**
     * Check default enter_mode property.
     */
    public function testDefaultEnterMode()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $enterMode = $view->vars['enter_mode'];

        $this->assertNull($enterMode);
    }

    /**
     * Checks enter_mode property.
     */
    public function testEnterMode()
    {
        $form = $this->factory->create($this->formType, null, array(
            'enter_mode' => 'ENTER_BR',
        ));

        $view = $form->createView();
        $enterMode = $view->vars['enter_mode'];

        $this->assertEquals($enterMode, 'ENTER_BR');
    }

    /**
     * Check default external_plugins property.
     */
    public function testDefaultExternalPlugins()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $externalPlugins = $view->vars['external_plugins'];

        $this->assertEquals($externalPlugins, array());
    }

    /**
     * Checks external_plugins property.
     */
    public function testExternalPlugins()
    {
        $form = $this->factory->create($this->formType, null, array(
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
     * Check default customConfig property.
     */
    public function testDefaultCustomConfig()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $customConfig = $view->vars['custom_config'];

        $this->assertNull($customConfig);
    }

    /**
     * Checks customConfig property.
     */
    public function testCustomConfig()
    {
        $form = $this->factory->create($this->formType, null, array(
            'custom_config' => 'someconfig.js',
        ));

        $view = $form->createView();
        $customConfig = $view->vars['custom_config'];

        $this->assertEquals($customConfig, 'someconfig.js');
    }

    /**
     * Check default templates_files property.
     */
    public function testDefaultTemplateFiles()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $templateFiles = $view->vars['templates_files'];

        $this->assertEquals($templateFiles, array());
    }

    /**
     * Checks templateFiles property.
     */
    public function testTemplateFiles()
    {
        $form = $this->factory->create($this->formType, null, array(
            'templates_files' => array(
                '/editor_templates/site_default.js',
                'http://www.example.com/user_templates.js',
            ),
        ));

        $view = $form->createView();
        $templateFiles = $view->vars['templates_files'];

        $this->assertEquals($templateFiles, array(
            '/editor_templates/site_default.js',
            'http://www.example.com/user_templates.js',
        ));
    }

    /**
     * Check default allowed_content property.
     */
    public function testDefaultAllowedContent()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $allowedContent = $view->vars['allowed_content'];

        $this->assertNull($allowedContent);
    }

    /**
     * Checks allowedContent property.
     */
    public function testAllowedContent()
    {
        $form = $this->factory->create($this->formType, null, array(
            'allowed_content' => 'h1',
        ));

        $view = $form->createView();
        $allowedContent = $view->vars['allowed_content'];

        $this->assertEquals($allowedContent, 'h1');
    }

    /**
     * Check default extra_allowed_content property.
     */
    public function testDefaultExtraAllowedContent()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $extraAllowedContent = $view->vars['extra_allowed_content'];

        $this->assertNull($extraAllowedContent);
    }

    /**
     * Checks extraAllowedContent property.
     */
    public function testExtraAllowedContent()
    {
        $form = $this->factory->create($this->formType, null, array(
            'extra_allowed_content' => 'b i',
        ));

        $view = $form->createView();
        $extraAllowedContent = $view->vars['extra_allowed_content'];

        $this->assertEquals($extraAllowedContent, 'b i');
    }

    /**
     * Check default templates_replace_content property.
     */
    public function testDefaultTemplatesReplaceContent()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $templatesReplaceContent = $view->vars['templates_replace_content'];

        $this->assertNull($templatesReplaceContent);
    }

    /**
     * Checks extraAllowedContent property.
     */
    public function testTemplatesReplaceContent()
    {
        $form = $this->factory->create($this->formType, null, array(
            'templates_replace_content' => false,
        ));

        $view = $form->createView();
        $templatesReplaceContent = $view->vars['templates_replace_content'];

        $this->assertFalse($templatesReplaceContent);
    }
}
