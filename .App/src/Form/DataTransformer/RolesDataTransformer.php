<?php

namespace App\Form\DataTransformer;

use App\Model\Roles;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class RolesDataTransformer implements DataTransformerInterface
{
    public function transform($value): ?string
    {
        $roles = $this->reverseTransform($value);

        return $roles instanceof Roles ? $roles->getvalue() : null;
    }

    public function reverseTransform($value): ?Roles
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if ($value instanceof Roles) {
            return $value;
        }

        try {
            return Roles::byValue($value);
        } catch (\Throwable $e) {
            throw new TransformationFailedException($e->getMessage(), $e->getCode(), $e);
        }
    }
}