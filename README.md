## Symfony2 CKEditor Bundle

[![Build Status](https://secure.travis-ci.org/trsteel88/TrsteelCkeditorBundle.png?branch=master)](http://travis-ci.org/trsteel88/TrsteelCkeditorBundle)

## Installation

1. Add TrsteelCkeditorBundle to your composer.json
2. Enable the bundle
3. Install bundle assets
4. Configure the bundle (optional)
5. Add the editor to a form
6. Configure data transformers

### Step 1: Add TrsteelCkeditorBundle to your composer.json
```js
{
    "require": {
        "Trsteel/ckeditor-bundle": "*"
    }
}
```

and update your project dependencies:

```bash
php composer.phar update Trsteel/ckeditor-bundle
```

### Step 2: Enable the bundle
``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Trsteel\CkeditorBundle\TrsteelCkeditorBundle(),
    );
}
```

### Step 3: Install bundle assets
```bash
$ php ./app/console assets:install web --symlink
```

--symlink is optional

### Step 4: Configure the bundle (optional)

For a full configuration dump use:
```bash
$ php ./app/console config:dump-reference TrsteelCkeditorBundle
```

An example configuration:

```yaml
trsteel_ckeditor:
    class: Trsteel\CkeditorBundle\Form\Type\CkeditorType
    transformers: ['strip_js', 'strip_css', 'strip_comments']
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
    ui_color: '#000000'
    startup_outline_blocks: true
    width: 800 #Integer or %
    height: 300 #Integer or %
    language: 'en-au'

```

Or even overwrite the 'document' toolbar group in your application completely.

```yaml
trsteel_ckeditor:
    class: Trsteel\CkeditorBundle\Form\Type\CkeditorType
    toolbar: ['document', 'clipboard', 'editing', '/', 'basicstyles', 'paragraph', 'links', '/', 'insert', 'styles', 'tools']
    toolbar_groups:
        document: ['Source']
```

You can create additional toolbar groups. Just create the group and specify the items. As you can see in the above config the 'document' toolbar group has been overwritten and only shows the 'Source' icon.

### Step 5: Add the editor to a form

Example form:

```php
<?php

$form = $this->createFormBuilder($post)
            ->add('title', 'text')
            ->add('content', 'ckeditor', array(
                'transformers'           => array('strip_js', 'strip_css', 'strip_comments'),
                'toolbar'                => array('document','basicstyles'),
                'toolbar_groups'         => array(
                    'document' => array('Source')
                ),
                'ui_color'               => '#fff',
                'startup_outline_blocks' => false,
                'width'                  => '100%',
                'height'                 => '320',
                'language'               => 'en-au',
            ))
            ->getForm()
;
```

Note: All parameters from config.yml can be overwritten in a form (excluding 'class').

### Step 6: Configure data transformers

Data transformers will automatically update the html content when the form is processed.

This bundle comes with several built-in transformers.

**strip_js:** Strips all javascript from the posted data

**strip_css:** Strips all css from the posted data

**strip_comments:** Strips all comments from html eg. <!-- This is a comment -->

If you do not want any transformers enabled you should disable them by:

1. Disable globally in the config:

```yaml
trsteel_ckeditor:
    transformers: []
```

2. Disable them on a particular form:

```php
<?php

$form = $this->createFormBuilder($post)
            ->add('title', 'text')
            ->add('content', 'ckeditor', array(
                'transformers' => array(),
            ))
            ->getForm()
;
```

## Next Steps

- [Creating your own transformers](/trsteel88/TrsteelCkeditorBundle/blob/master/Resources/doc/transformers.md)
- [Adding additional CKEditor Javascript plugins](/trsteel88/TrsteelCkeditorBundle/blob/master/Resources/doc/ckeditor-plugins.md)
