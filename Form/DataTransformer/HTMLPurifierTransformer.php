<?php

namespace Trsteel\CkeditorBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class HTMLPurifierTransformer implements DataTransformerInterface
{
    private \HTMLPurifier $purifier;

    private array $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function transform(mixed $value): mixed
    {
        return $value;
    }

    public function reverseTransform(mixed $value): mixed
    {
        return $this->getPurifier()->purify($value);
    }

    protected function getPurifier(): \HTMLPurifier
    {
        if (null === $this->purifier) {
            $this->purifier = new \HTMLPurifier($this->config);
        }

        return $this->purifier;
    }
}
