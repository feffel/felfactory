<?php
/** @noinspection PhpDocMissingThrowsInspection */
declare(strict_types=1);

namespace felfactory\ConfigLoader;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use felfactory\Annotation\Shape;
use ReflectionClass;

class AnnotationLoader
{
    /** @var AnnotationReader */
    protected $reader;

    public function __construct()
    {
        /** @noinspection PhpDeprecationInspection */
        AnnotationRegistry::registerLoader('class_exists');
        $this->reader = new AnnotationReader();
    }

    /**
     * @param string $className
     * @psalm-param class-string $className
     * @return string[]
     * @psalm-return array<string, string>
     */
    public function load(string $className): array
    {
        $reflection = new ReflectionClass($className);
        $properties = $reflection->getProperties();
        $config     = [];
        foreach ($properties as $property) {
            $shape = $this->reader->getPropertyAnnotation($property, Shape::class);
            if ($shape && $shape->shape) {
                $config[$property->getName()] = $shape->shape;
            }
        }

        return $config;
    }
}
