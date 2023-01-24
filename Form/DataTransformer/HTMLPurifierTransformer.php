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
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function transform(mixed $value): mixed
    {
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform(mixed $value): mixed
    {
        return $this->getPurifier()->purify($value);
    }

    /**
     * @return \HTMLPurifier
     */
    protected function getPurifier()
    {
        if (null === $this->purifier) {
            $this->purifier = new \HTMLPurifier($this->config);
        }

        return $this->purifier;
    }
}
