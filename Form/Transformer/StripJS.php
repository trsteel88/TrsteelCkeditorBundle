<?php

namespace Trsteel\CkeditorBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class StripJS implements DataTransformerInterface
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
        return preg_replace('/<script[^>]*>(.*?)<\/script>/is', '', $data) ?: null;
    }
}