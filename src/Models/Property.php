<?php
declare(strict_types=1);

namespace felfactory\Models;

use ReflectionProperty;

class Property
{
    /** @var string */
    public $name;

    /** @var string */
    public $type;

    /** @var ReflectionProperty */
    public $ref;

    /** @var string */
    public $callback;

    public static function fromReflection(ReflectionProperty $refProperty, string $type = null): self
    {
        $property       = new self();
        $property->name = $refProperty->getName();
        $property->ref  = $refProperty;
        $property->type = $type;

        return $property;
    }
}
