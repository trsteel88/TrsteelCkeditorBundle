## Creating your own transformers

Transformers are used to change the html data before it is saved.

For an example transformer see [/trsteel88/TrsteelCkeditorBundle/blob/master/Form/Transformer/StripJS.php](/trsteel88/TrsteelCkeditorBundle/blob/master/Form/Transformer/StripJS.php)

### Step 1: Create your transformer

src/AcmeDemoBundle/Transformer/RemoveImages.php

```php
<?php

namespace Acme\DemoBundle\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class RemoveImages implements DataTransformerInterface
{
    /**
     * {@inheritDoc}
     */
    public function transform($data)
    {
        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function reverseTransform($data)
    {
        return preg_replace('/<img[^>]+\>/is', '', $data);
    }
}
```

### Step 2: Tag your transformer so it can be detected.

src/AcmeDemoBundle/config/services.yml

```yaml
    acme_demo_ckeditor.transformer.remove_images:
        class: Acme\DemoBundle\Transformer\RemoveImages
        tags:
            - { name: trsteel_ckeditor.transformer, alias: remove_images }
```

Note: The alias must be unique.

### Step 3: Enable your custom transformer

Enable the transformer globally in config.yml

```yaml
trsteel_ckeditor:
    transformers: ['remove_images']
```

Or enable it on a specific form

```php
<?php

$form = $this->createFormBuilder($post)
            ->add('title', 'text')
            ->add('content', 'ckeditor', array(
                'transformers' => array('remove_images'),
            ))
            ->getForm()
;
```

Note: If you override the transformers value none of the default transformers will be including (eg html_purifier)
