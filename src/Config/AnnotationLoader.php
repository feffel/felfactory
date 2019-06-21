<?php
/** @noinspection PhpDocMissingThrowsInspection */
declare(strict_types=1);

namespace felfactory\Config;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use felfactory\Annotation\Figure;
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
            /** @var Figure|null $figure */
            $figure = $this->reader->getPropertyAnnotation($property, Figure::class);
            if ($figure && $figure->figure) {
                $config[$property->getName()] = $figure->figure;
            }
        }

        return $config;
    }
}
