<?php

namespace SatisAdmin\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class ArrayToJsonDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritDoc}
     */
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }
        $encoded = json_encode($value);

        return substr($encoded, 1, strlen($encoded) - 2);
    }

    /**
     * {@inheritDoc}
     */
    public function reverseTransform($value)
    {
        if ('' === $value) {
            return null;
        }

        return json_decode('{'.$value.'}', true);
    }
}
