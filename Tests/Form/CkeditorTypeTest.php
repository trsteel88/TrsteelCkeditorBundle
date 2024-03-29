<?php

namespace Trsteel\CkeditorBundle\Tests\Form;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;
use Trsteel\CkeditorBundle\Form\Type\CkeditorType;
use Trsteel\CkeditorBundle\Tests\AppKernel;

class CkeditorTypeTest extends TestCase
{
    protected static $kernel;

    protected static $container;

    private FormFactoryInterface $factory;

    private string $formType;

    /**
     * {@inheritdooc}.
     */
    public static function setUpBeforeClass(): void
    {
        self::$kernel = new AppKernel('dev', true);
        self::$kernel->boot();

        self::$container = self::$kernel->getContainer();
    }

    /**
     * {@inheritdooc}.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $ckeditorType = new CkeditorType($this->get('service_container'));

        $this->factory = Forms::createFormFactoryBuilder()
            ->addType($ckeditorType)
            ->getFormFactory();

        $this->formType = method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix') ? 'Trsteel\CkeditorBundle\Form\Type\CkeditorType' : 'ckeditor';
    }

    /**
     * Get service from container by id.
     *
     * @param string $serviceId
     */
    public function get($serviceId)
    {
        return self::$kernel->getContainer()->get($serviceId);
    }

    /**
     * Check the default required property.
     */
    public function testDefaultAutoloadCkeditorJs()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $autoloadCkeditorJs = $view->vars['autoload_ckeditor_js'];

        $this->assertTrue($autoloadCkeditorJs);
    }

    /**
     * Check the required property.
     */
    public function testAutoloadCkeditorJs()
    {
        $form = $this->factory->create($this->formType, null, [
            'autoload_ckeditor_js' => true,
        ]);

        $view = $form->createView();
        $autoloadCkeditorJs = $view->vars['autoload_ckeditor_js'];

        $this->assertSame($autoloadCkeditorJs, true);
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
        $form = $this->factory->create($this->formType, null, [
            'required' => true,
        ]);

        $view = $form->createView();
        $required = $view->vars['required'];

        $this->assertSame($required, true);
    }

    /**
     * Check the default toolbar property.
     */
    public function testDefaultToolbar()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $toolbar = $view->vars['toolbar'];

        $this->assertSame($toolbar, [
            [
                'name' => 'document',
                'items' => [
                    'Source',
                    '-',
                    'Save',
                    '-',
                    'Templates',
                ],
            ],
            [
                'name' => 'clipboard',
                'items' => [
                    'Cut',
                    'Copy',
                    'Paste',
                    'PasteText',
                    'PasteFromWord',
                    '-',
                    'Undo',
                    'Redo',
                ],
            ],
            [
                'name' => 'editing',
                'items' => [
                    'Find',
                    'Replace',
                    '-',
                    'SelectAll',
                ],
            ],
            '/',
            [
                'name' => 'basicstyles',
                'items' => [
                    'Bold',
                    'Italic',
                    'Underline',
                    'Strike',
                    'Subscript',
                    'Superscript',
                    '-',
                    'RemoveFormat',
                ],
            ],
            [
                'name' => 'paragraph',
                'items' => [
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
                ],
            ],
            [
                'name' => 'links',
                'items' => [
                    'Link',
                    'Unlink',
                    'Anchor',
                ],
            ],
            '/',
            [
                'name' => 'insert',
                'items' => [
                    'Image',
                    'Flash',
                    'Table',
                    'HorizontalRule',
                ],
            ],
            [
                'name' => 'styles',
                'items' => [
                    'Styles',
                    'Format',
                ],
            ],
            [
                'name' => 'tools',
                'items' => [
                    'Maximize',
                    'ShowBlocks',
                ],
            ],
        ]);
    }

    /**
     * Check the toolbar property.
     */
    public function testToolbar()
    {
        $form = $this->factory->create($this->formType, null, [
            'toolbar' => [
                'document',
            ],
            'toolbar_groups' => [
                'document' => [
                    'Source',
                ],
            ],
        ]);
        $view = $form->createView();
        $toolbar = $view->vars['toolbar'];

        $this->assertSame($toolbar, [
            [
                'name' => 'document',
                'items' => [
                    'Source',
                ],
            ],
        ]);
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
        $form = $this->factory->create($this->formType, null, [
            'startup_outline_blocks' => false,
        ]);

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
        $form = $this->factory->create($this->formType, null, [
            'ui_color' => '#333333',
        ]);

        $view = $form->createView();
        $ui_color = $view->vars['ui_color'];

        $this->assertSame($ui_color, '#333333');
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
        $form = $this->factory->create($this->formType, null, [
            'width' => '100%',
        ]);

        $view = $form->createView();
        $width = $view->vars['width'];

        $this->assertSame($width, '100%');
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
        $form = $this->factory->create($this->formType, null, [
            'height' => '350px',
        ]);

        $view = $form->createView();
        $height = $view->vars['height'];

        $this->assertSame($height, '350px');
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
        $form = $this->factory->create($this->formType, null, [
            'language' => 'en-au',
        ]);

        $view = $form->createView();
        $language = $view->vars['language'];

        $this->assertSame($language, 'en-au');
    }

    /**
     * Check the default filebrowserBrowseUrl property.
     */
    public function testDefaultFileBrowserBrowseUrl()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_browse_url'];

        $this->assertSame($filebrowserBrowseUrl, [
            'url' => null,
            'route' => null,
            'route_parameters' => [],
        ]);
    }

    /**
     * Checks filebrowserBrowseUrl property.
     */
    public function testFileBrowserBrowseUrl()
    {
        $form = $this->factory->create($this->formType, null, [
            'filebrowser_browse_url' => '/myfilebrowser/browser.html',
        ]);

        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_browse_url'];

        $this->assertSame($filebrowserBrowseUrl, '/myfilebrowser/browser.html');
    }

    /**
     * Checks filebrowserBrowseUrl property.
     */
    public function testFileBrowserBrowseUrlRoute()
    {
        $form = $this->factory->create($this->formType, null, [
            'filebrowser_browse_url' => [
                'route' => 'file_browser',
                'route_parameters' => [
                    'type' => 'file',
                ],
            ],
        ]);

        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_browse_url'];

        $this->assertSame($filebrowserBrowseUrl, [
            'route' => 'file_browser',
            'route_parameters' => [
                'type' => 'file',
            ],
        ]);
    }

    /**
     * Check the default filebrowserUploadUrl property.
     */
    public function testDefaultFileBrowserUploadUrl()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_upload_url'];

        $this->assertSame($filebrowserBrowseUrl, [
            'url' => null,
            'route' => null,
            'route_parameters' => [],
        ]);
    }

    /**
     * Checks filebrowserUploadUrl property.
     */
    public function testFileBrowserUploadUrl()
    {
        $form = $this->factory->create($this->formType, null, [
            'filebrowser_upload_url' => '/myfilebrowser/uploads',
        ]);

        $view = $form->createView();
        $filebrowserUploadUrl = $view->vars['filebrowser_upload_url'];

        $this->assertSame($filebrowserUploadUrl, '/myfilebrowser/uploads');
    }

    /**
     * Checks filebrowserUploadUrl property.
     */
    public function testFileBrowserUploadUrlRoute()
    {
        $form = $this->factory->create($this->formType, null, [
            'filebrowser_upload_url' => [
                'route' => 'file_browser_upload',
                'route_parameters' => [
                    'type' => 'file',
                ],
            ],
        ]);

        $view = $form->createView();
        $filebrowserUploadUrl = $view->vars['filebrowser_upload_url'];

        $this->assertSame($filebrowserUploadUrl, [
            'route' => 'file_browser_upload',
            'route_parameters' => [
                'type' => 'file',
            ],
        ]);
    }

    /**
     * Check the default filebrowserImageBrowseUrl property.
     */
    public function testDefaultFileBrowserImageBrowseUrl()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_image_browse_url'];

        $this->assertSame($filebrowserBrowseUrl, [
            'url' => null,
            'route' => null,
            'route_parameters' => [],
        ]);
    }

    /**
     * Checks filebrowserImageBrowseUrl property.
     */
    public function testFileBrowserImageBrowseUrl()
    {
        $form = $this->factory->create($this->formType, null, [
            'filebrowser_image_browse_url' => '/myfilebrowser/browser.html',
        ]);

        $view = $form->createView();
        $filebrowserImageBrowseUrl = $view->vars['filebrowser_image_browse_url'];

        $this->assertSame($filebrowserImageBrowseUrl, '/myfilebrowser/browser.html');
    }

    /**
     * Checks filebrowserImageBrowseUrl property.
     */
    public function testFileBrowserImageBrowseUrlRoute()
    {
        $form = $this->factory->create($this->formType, null, [
            'filebrowser_image_browse_url' => [
                'route' => 'file_browser',
                'route_parameters' => [
                    'type' => 'image',
                ],
            ],
        ]);

        $view = $form->createView();
        $filebrowserImageBrowseUrl = $view->vars['filebrowser_image_browse_url'];

        $this->assertSame($filebrowserImageBrowseUrl, [
            'route' => 'file_browser',
            'route_parameters' => [
                'type' => 'image',
            ],
        ]);
    }

    /**
     * Check the default filebrowserImageUploadUrl property.
     */
    public function testDefaultFileBrowserImageUploadUrl()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_image_upload_url'];

        $this->assertSame($filebrowserBrowseUrl, [
            'url' => null,
            'route' => null,
            'route_parameters' => [],
        ]);
    }

    /**
     * Checks filebrowserImageUploadUrl property.
     */
    public function testFileBrowserImageUploadUrl()
    {
        $form = $this->factory->create($this->formType, null, [
            'filebrowser_image_upload_url' => '/myfilebrowser/uploads',
        ]);

        $view = $form->createView();
        $filebrowserImageUploadUrl = $view->vars['filebrowser_image_upload_url'];

        $this->assertSame($filebrowserImageUploadUrl, '/myfilebrowser/uploads');
    }

    /**
     * Checks filebrowserImageUploadUrl property.
     */
    public function testFileBrowserImageUploadUrlRoute()
    {
        $form = $this->factory->create($this->formType, null, [
            'filebrowser_image_upload_url' => [
                'route' => 'file_browser_upload',
                'route_parameters' => [
                    'type' => 'image',
                ],
            ],
        ]);

        $view = $form->createView();
        $filebrowserImageUploadUrl = $view->vars['filebrowser_image_upload_url'];

        $this->assertSame($filebrowserImageUploadUrl, [
            'route' => 'file_browser_upload',
            'route_parameters' => [
                'type' => 'image',
            ],
        ]);
    }

    /**
     * Check the default filebrowserFlashBrowseUrl property.
     */
    public function testDefaultFileBrowserFlashBrowseUrl()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_flash_browse_url'];

        $this->assertSame($filebrowserBrowseUrl, [
            'url' => null,
            'route' => null,
            'route_parameters' => [],
        ]);
    }

    /**
     * Checks filebrowserFlashBrowseUrl property.
     */
    public function testFileBrowserFlashBrowseUrl()
    {
        $form = $this->factory->create($this->formType, null, [
            'filebrowser_flash_browse_url' => '/myfilebrowser/browser.html',
        ]);

        $view = $form->createView();
        $filebrowserFlashBrowseUrl = $view->vars['filebrowser_flash_browse_url'];

        $this->assertSame($filebrowserFlashBrowseUrl, '/myfilebrowser/browser.html');
    }

    /**
     * Checks filebrowserFlashBrowseUrl property.
     */
    public function testFileBrowserFlashBrowseUrlRoute()
    {
        $form = $this->factory->create($this->formType, null, [
            'filebrowser_flash_browse_url' => [
                'route' => 'file_browser',
                'route_parameters' => [
                    'type' => 'flash',
                ],
            ],
        ]);

        $view = $form->createView();
        $filebrowserFlashBrowseUrl = $view->vars['filebrowser_flash_browse_url'];

        $this->assertSame($filebrowserFlashBrowseUrl, [
            'route' => 'file_browser',
            'route_parameters' => [
                'type' => 'flash',
            ],
        ]);
    }

    /**
     * Check the default filebrowserFlashUploadUrl property.
     */
    public function testDefaultFileBrowserFlashUploadUrl()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $filebrowserBrowseUrl = $view->vars['filebrowser_flash_upload_url'];

        $this->assertSame($filebrowserBrowseUrl, [
            'url' => null,
            'route' => null,
            'route_parameters' => [],
        ]);
    }

    /**
     * Checks filebrowserFlashUploadUrl property.
     */
    public function testFileBrowserFlashUploadUrl()
    {
        $form = $this->factory->create($this->formType, null, [
            'filebrowser_flash_upload_url' => '/myfilebrowser/uploads',
        ]);

        $view = $form->createView();
        $filebrowserFlashUploadUrl = $view->vars['filebrowser_flash_upload_url'];

        $this->assertSame($filebrowserFlashUploadUrl, '/myfilebrowser/uploads');
    }

    /**
     * Checks filebrowserFlashUploadUrl property.
     */
    public function testFileBrowserFlashUploadUrlRoute()
    {
        $form = $this->factory->create($this->formType, null, [
            'filebrowser_flash_upload_url' => [
                'route' => 'file_browser_upload',
                'route_parameters' => [
                    'type' => 'flash',
                ],
            ],
        ]);

        $view = $form->createView();
        $filebrowserFlashUploadUrl = $view->vars['filebrowser_flash_upload_url'];

        $this->assertSame($filebrowserFlashUploadUrl, [
            'route' => 'file_browser_upload',
            'route_parameters' => [
                'type' => 'flash',
            ],
        ]);
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
        $form = $this->factory->create($this->formType, null, [
            'skin' => 'myskin,/skins/myskin/',
        ]);

        $view = $form->createView();
        $skin = $view->vars['skin'];

        $this->assertSame($skin, 'myskin,/skins/myskin/');
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
        $form = $this->factory->create($this->formType, null, [
            'disable_native_spell_checker' => true,
        ]);

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

        $this->assertSame($formatTags, []);
    }

    /**
     * Checks format_tags property.
     */
    public function testFormatTags()
    {
        $form = $this->factory->create($this->formType, null, [
            'format_tags' => ['p', 'h2', 'h3', 'pre'],
        ]);

        $view = $form->createView();
        $formatTags = $view->vars['format_tags'];

        $this->assertSame($formatTags, ['p', 'h2', 'h3', 'pre']);
    }

    /**
     * Check default base_path property.
     */
    public function testDefaultBasePath()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $basePath = $view->vars['base_path'];

        $this->assertSame($basePath, 'bundles/trsteelckeditor/');
    }

    /**
     * Checks base_path property.
     */
    public function testBasePath()
    {
        $form = $this->factory->create($this->formType, null, [
            'base_path' => '/lib/ckeditor/',
        ]);

        $view = $form->createView();
        $basePath = $view->vars['base_path'];

        $this->assertSame($basePath, '/lib/ckeditor/');
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
        $form = $this->factory->create($this->formType, null, [
            'base_href' => 'http://domain.com/',
        ]);

        $view = $form->createView();
        $baseHref = $view->vars['base_href'];

        $this->assertSame($baseHref, 'http://domain.com/');
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
        $form = $this->factory->create($this->formType, null, [
            'body_class' => 'special_class',
        ]);

        $view = $form->createView();
        $bodyClass = $view->vars['body_class'];

        $this->assertSame($bodyClass, 'special_class');
    }

    /**
     * Check default contents_css property.
     */
    public function testDefaultContentsCss()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $contentsCss = $view->vars['contents_css'];

        $this->assertSame($contentsCss, []);
    }

    /**
     * Checks contents_css property.
     */
    public function testContentsCssAsArray()
    {
        $form = $this->factory->create($this->formType, null, [
            'contents_css' => [
                '/css/ckeditor/contents1.css',
                '/css/ckeditor/contents2.css',
            ],
        ]);

        $view = $form->createView();
        $contentsCss = $view->vars['contents_css'];

        $this->assertSame($contentsCss, [
            '/css/ckeditor/contents1.css',
            '/css/ckeditor/contents2.css',
        ]);
    }

    /**
     * Checks contents_css property as a string.
     */
    public function testContentsCssAsString()
    {
        $form = $this->factory->create($this->formType, null, [
            'contents_css' => '/css/ckeditor/contents.css',
        ]);

        $view = $form->createView();
        $contentsCss = $view->vars['contents_css'];

        $this->assertSame($contentsCss, '/css/ckeditor/contents.css');
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
        $form = $this->factory->create($this->formType, null, [
            'basic_entities' => false,
        ]);

        $view = $form->createView();
        $basicEntities = $view->vars['basic_entities'];

        $this->assertSame($basicEntities, false);
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
        $form = $this->factory->create($this->formType, null, [
            'entities' => false,
        ]);

        $view = $form->createView();
        $entities = $view->vars['entities'];

        $this->assertSame($entities, false);
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
        $form = $this->factory->create($this->formType, null, [
            'entities_latin' => false,
        ]);

        $view = $form->createView();
        $entitiesLatin = $view->vars['entities_latin'];

        $this->assertSame($entitiesLatin, false);
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
        $form = $this->factory->create($this->formType, null, [
            'startup_mode' => 'source',
        ]);

        $view = $form->createView();
        $startupMode = $view->vars['startup_mode'];

        $this->assertSame($startupMode, 'source');
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
        $form = $this->factory->create($this->formType, null, [
            'enter_mode' => 'ENTER_BR',
        ]);

        $view = $form->createView();
        $enterMode = $view->vars['enter_mode'];

        $this->assertSame($enterMode, 'ENTER_BR');
    }

    /**
     * Check default external_plugins property.
     */
    public function testDefaultExternalPlugins()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $externalPlugins = $view->vars['external_plugins'];

        $this->assertSame($externalPlugins, []);
    }

    /**
     * Checks external_plugins property.
     */
    public function testExternalPlugins()
    {
        $form = $this->factory->create($this->formType, null, [
            'external_plugins' => [
                'my_custom_plugin' => [
                    'path' => 'js/ckeditor/plugins/my_custom_plugin',
                    'file' => 'plugin.js',
                ],
            ],
        ]);
        $view = $form->createView();
        $externalPlugins = $view->vars['external_plugins'];

        $this->assertSame($externalPlugins, [
            'my_custom_plugin' => [
                'path' => 'js/ckeditor/plugins/my_custom_plugin',
                'file' => 'plugin.js',
            ],
        ]);
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
        $form = $this->factory->create($this->formType, null, [
            'custom_config' => 'someconfig.js',
        ]);

        $view = $form->createView();
        $customConfig = $view->vars['custom_config'];

        $this->assertSame($customConfig, 'someconfig.js');
    }

    /**
     * Check default templates_files property.
     */
    public function testDefaultTemplateFiles()
    {
        $form = $this->factory->create($this->formType);
        $view = $form->createView();
        $templateFiles = $view->vars['templates_files'];

        $this->assertSame($templateFiles, []);
    }

    /**
     * Checks templateFiles property.
     */
    public function testTemplateFiles()
    {
        $form = $this->factory->create($this->formType, null, [
            'templates_files' => [
                '/editor_templates/site_default.js',
                'http://www.example.com/user_templates.js',
            ],
        ]);

        $view = $form->createView();
        $templateFiles = $view->vars['templates_files'];

        $this->assertSame($templateFiles, [
            '/editor_templates/site_default.js',
            'http://www.example.com/user_templates.js',
        ]);
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
        $form = $this->factory->create($this->formType, null, [
            'allowed_content' => 'h1',
        ]);

        $view = $form->createView();
        $allowedContent = $view->vars['allowed_content'];

        $this->assertSame($allowedContent, 'h1');
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
        $form = $this->factory->create($this->formType, null, [
            'extra_allowed_content' => 'b i',
        ]);

        $view = $form->createView();
        $extraAllowedContent = $view->vars['extra_allowed_content'];

        $this->assertSame($extraAllowedContent, 'b i');
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
        $form = $this->factory->create($this->formType, null, [
            'templates_replace_content' => false,
        ]);

        $view = $form->createView();
        $templatesReplaceContent = $view->vars['templates_replace_content'];

        $this->assertFalse($templatesReplaceContent);
    }
}
