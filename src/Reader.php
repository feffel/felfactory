<?php
declare(strict_types=1);

namespace felfactory;

use felfactory\Models\Property;
use PhpDocReader\PhpDocReader;
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
            $property                    = Property::fromReflection(
                $reflectionProperty,
                $this->reader->getPropertyClass($reflectionProperty)
            );
            $properties[$property->name] = $property;
        }

        return $properties;
    }
}
