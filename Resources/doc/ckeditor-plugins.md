## Adding additional CKEditor Javascript Plugins

The following example will be based on the syntaxhighlight plugin found here: http://code.google.com/p/ckeditor-syntaxhighlight/wiki/Installation

### Step 1: Download plugin

Download the plugin and place in /web/js/ckeditor/plugins/syntaxhighlight/

### Step 2: Include the external plugin in your config.

```yaml
trsteel_ckeditor:
    external_plugins:
            syntaxhighlight:
                path: js/ckeditor/plugins/syntaxhighlight
```

### Step 3: Add the plugin to your toolbar either in the global config or form specific config.

```yaml
trsteel_ckeditor:
    toolbar:
        - document
    toolbar_groups:
        document: ['Source','Code']
    ui_color: '#000000'
```

Or enable it on a specific form

```php
<?php

$form = $this->createFormBuilder($post)
            ->add('title', 'text')
            ->add('content', 'ckeditor', array(
                'toolbar'        => array('document'),
                'toolbar_groups' => array(
                    'document' => array('Source','Code'),
                ),
            ))
            ->getForm()
;
```