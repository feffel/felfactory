<?php
declare(strict_types=1);

namespace felfactory;

use Faker\Generator;
use felfactory\ConfigLoader\ConfigLoader;
use felfactory\Models\Property;
use felfactory\Parser\Parser;
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
    /** @var StatementExecutor */
    protected $executor;
    public function __construct(Generator $generator = null)
    {
        $this->reader       = new Reader();
        $this->configLoader = new ConfigLoader();
        $this->generator    = $generator ?? \Faker\Factory::create();
        $this->guesser      = new Guesser($this->generator);
        $this->executor     = new StatementExecutor($this->generator, [$this, 'generate']);
    }

    /**
     * @param string $className
     * @psalm-param class-string $className
     * @return Property[]
     */
    protected function configure(string $className): array
    {
        $properties = $this->reader->readProperties($className);
        $config     = $this->configLoader->load($className);
        foreach ($config as $propertyName => $propertyConfig) {
            $parser                              = new Parser($propertyConfig);
            $properties[$propertyName]->callback = $this->executor->execute($parser->parse());
        }
        /** @var Property[] $nonConfiguredProperties */
        $nonConfiguredProperties = array_filter(
            $properties,
            static function (Property $property): bool {
                return $property->callback === null;
            }
        );
        foreach ($nonConfiguredProperties as $property) {
            $type = $property->type;
            if ($type === null) {
                $property->callback = $this->guesser->guess($property);
            } else {
                $property->callback = function () use ($type): object {
                    return $this->generate($type);
                };
            }
        }

        return $properties;
    }

    /**
     * @param callable|null $callback
     * @return mixed|null
     */
    protected function evaluateCallback(?callable $callback)
    {
        if ($callback) {
            return $callback();
        }

        return null;
    }

    /**
     * @param string $className
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
            $val = $this->evaluateCallback($property->callback);
            $property->ref->setValue($obj, $val);
        }

        return $obj;
    }
}
