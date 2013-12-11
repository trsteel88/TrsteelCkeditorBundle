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
        return $this->getPurifier()->purify($value);
    }

    /**
     * @return \HTMLPurifier
     */
    protected function getPurifier()
    {
        if (null === $this->purifier) {
            $this->purifier = new \HTMLPurifier();
        }

        return $this->purifier;
    }
}
