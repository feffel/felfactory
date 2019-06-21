<?php
declare(strict_types=1);

namespace felfactory;

use felfactory\Models\Property;
use ReflectionClass;

class Reader
{
    /** @var PhpDocReader */
    protected $reader;

    public function __construct()
    {
        $this->reader = new PhpDocReader();
    }

    /** @noinspection PhpDocMissingThrowsInspection */
    /**
     * @param string $className
     * @psalm-param class-string $className
     *
     * @return Property[]
     */
    public function readProperties(string $className): array
    {
        $reflectionClass      = new ReflectionClass($className);
        $reflectionProperties = $reflectionClass->getProperties();
        $properties           = [];
        foreach ($reflectionProperties as $reflectionProperty) {
            $reflectionProperty->setAccessible(true);
            $type = $this->reader->getPropertyClass($reflectionProperty);
            $property                    = new Property(
                $reflectionProperty,
                $type,
                $type ? $this->reader->isPrimitive($type) : null
            );
            $properties[$property->getName()] = $property;
        }

        return $properties;
    }
}
