<?php
declare(strict_types=1);

namespace felfactory;

use Faker\Generator;
use felfactory\Models\Property;
use InvalidArgumentException;
use ReflectionException;

/**
 * cool
 * Class Factory
 *
 * @package felfactory
 */
class Factory
{
    protected const SELF_NESTING_TOLERANCE = 1;

    /** @var Reader */
    protected $reader;
    /** @var ConfigLoader */
    protected $configLoader;
    /** @var Generator */
    protected $generator;
    /** @var Guesser */
    protected $guesser;
    /** @var ConfigParser */
    protected $parser;

    public function __construct(Generator $generator = null)
    {
        $this->reader       = new Reader();
        $this->configLoader = new ConfigLoader();
        $this->generator    = $generator ?? \Faker\Factory::create();
        $this->parser       = new ConfigParser($this->generator);
        $this->guesser      = new Guesser($this->generator);
    }

    /**
     * @param $className
     *
     * @return Property[]
     */
    protected function configure($className): array
    {
        $properties = $this->reader->readProperties($className);
        $config     = $this->configLoader->load($className)($this->generator);
        foreach ($config as $propertyName => $callable) {
            $properties[$propertyName]->callback = $this->parser->parse($callable);
        }
        /** @var Property[] $nonConfiguredProperties */
        $nonConfiguredProperties = array_filter(
            $properties,
            static function (Property $property) {
                return $property->callback === null;
            }
        );
        foreach ($nonConfiguredProperties as $property) {
            if ($property->type === null) {
                $property->callback = $this->guesser->guess($property);
            } else {
                $property->callback = function () use ($property) {
                    return $this->generate($property->type);
                };
            }
        }

        return $properties;
    }

    /**
     * @param string $className
     *
     * @return object
     * @throws ReflectionException
     */
    public function generate(string $className)
    {
        if (!class_exists($className)) {
            throw  new InvalidArgumentException("Couldn't load $className");
        }
        $config = $this->configure($className);
        $class  = new \ReflectionClass($className);
        $obj    = $class->newInstance();
        foreach ($config as $property) {
            $val = ($property->callback)();
            $property->ref->setValue($obj, $val);
        }

        return $obj;
    }
}
