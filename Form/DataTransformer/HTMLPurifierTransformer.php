<?php

namespace Trsteel\CkeditorBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class HTMLPurifierTransformer implements DataTransformerInterface
{
    /**
     * @var \HTMLPurifier
     */
    private $purifier;

    /**
     * Constructor.
     *
     * @param \HTMLPurifier $purifier
     */
    public function __construct(\HTMLPurifier $purifier)
    {
        $this->purifier = $purifier;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        return $this->purifier->purify($value);
    }
}
