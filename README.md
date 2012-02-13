Symfony2 CKEditor Bundle

[![Build Status](https://secure.travis-ci.org/trsteel88/TrsteelCkeditorBundle.png?branch=master)](http://travis-ci.org/trsteel88/TrsteelCkeditorBundle)

Add the following lines to the deps file:

    [TrsteelCkeditorBundle]
        git=http://github.com/trsteel88/TrsteelCkeditorBundle.git
        target=/bundles/Trsteel/CkeditorBundle

Update your vendors by running:

```bash
$ php ./bin/vendors
```

Add the Trsteel namespace to your autoloader.

```php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    'Trsteel' => __DIR__.'/../vendor/bundles',
    // your other namespaces
));
```

Add the bundle to the application kernal.

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        // ...
        new Trsteel\CkeditorBundle\TrsteelCkeditorBundle(),
        // ...
    );
}
```

Install assets.

```bash
$ php ./app/console assets:install web --symlink
```

Configure the default settings for the app. This step is not required for the bundle to function.

```yaml
trsteel_ckeditor:
    class: Trsteel\CkeditorBundle\Form\CkeditorType
    toolbar: ['document', 'clipboard', 'editing', '/', 'basicstyles', 'paragraph', 'links', '/', 'insert', 'styles', 'tools']
    toolbar_groups:
        document: ['Source','-','Save','-','Templates']
        clipboard: ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo']
        editing: ['Find','Replace','-','SelectAll']
        basicstyles: ['Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat']
        paragraph: ['NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft', 'JustifyCenter','JustifyRight','JustifyBlock']
        links: ['Link','Unlink','Anchor']
        insert: ['Image','Flash','Table','HorizontalRule']
        styles: ['Styles','Format']
        tools: ['Maximize', 'ShowBlocks']
    ui_colour: '#000000'
    startup_outline_blocks: true
    width: 800 #Integer or %
    height: 300 #Integer or %

```

These settings can also be configured for a specific form.

```php
<?php

$form = $this->createFormBuilder($post)
            ->add('title', 'text')
            ->add('content', 'ckeditor', array(
                'toolbar' => array('document','basicstyles'),
                'toolbar_groups' => array(
                    'document' => array('Source')
                )
                'ui_colour' => '#fff',
                'startup_outline_blocks' => false,
                'width'    => '100%',
                'height' => '300',
            ))
            ->getForm()
;
```

You can create additional toolbar groups. Just create the group and specify the items. As you can see in the above form the 'document' toolbar group has been overwritten and only shows the 'Source' icon.

In your config.yml you could add an additional toolbar_group:

```yaml
trsteel_ckeditor:
    toolbar: ['document_with_source_only', 'clipboard', 'editing', '/', 'basicstyles', 'paragraph', 'links']
    toolbar_groups:
        document_with_source_only: ['Source']
```

Or even overwrite the 'document' toolbar group in your application completely.

```yaml
trsteel_ckeditor:
    class: Trsteel\CkeditorBundle\Form\CkeditorType
    toolbar: ['document', 'clipboard', 'editing', '/', 'basicstyles', 'paragraph', 'links', '/', 'insert', 'styles', 'tools']
    toolbar_groups:
        document: ['Source']
```