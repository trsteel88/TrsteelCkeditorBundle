<?php

namespace Trsteel\CkeditorBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class StripCSS implements DataTransformerInterface
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
        return preg_replace('/<style[^>]*>(.*?)<\/style>/is', '', $data) ?: null;
    }
}