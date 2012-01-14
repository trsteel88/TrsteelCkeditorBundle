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

Configure the default settings for the app. This step is not required for the bundle to function.

```yaml
trsteel_ckeditor:
	class: Trsteel\CkeditorBundle\Form\CkeditorType
    uiColor: '#000'
    startupOutlineBlocks: true
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
```

These settings can also be configured for a specific form.

```php
<?php

$form = $this->createFormBuilder($post)
            ->add('title', 'text')
            ->add('content', 'ckeditor', array(
				'uiColor' => '#fff',
				'startupOutlineBlocks' => false,
            	'toolbar' => array('document','basicstyles'),
				'toolbar_groups' => array(
					'document' => array('Source')
				)
            ))
            ->getForm()
;
```

You can create additional toolbar groups. Just create the group and specify the items.

Install assets.
```bash
$ php ./app/console assets:install web --symlink
```