<?php
declare(strict_types=1);

namespace felfactory;

use Faker\Generator;
use felfactory\Config\Configurator;
use felfactory\Guesser\Guesser;
use felfactory\Models\Property;
use felfactory\Statement\StatementExecutor;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

/**
 * Class Factory
 *
 * @package felfactory
 */
class Factory
{
    protected const SELF_NESTING_TOLERANCE = 1;

    /** @var Configurator */
    protected $configurator;
    /** @var Generator */
    protected $generator;
    /** @var Guesser */
    protected $guesser;
    /** @var StatementExecutor */
    protected $executor;
    /** @var GenerationStack */
    protected $stack;

    public function __construct(Generator $generator = null)
    {
        $this->configurator = new Configurator();
        $this->generator    = $generator ?? \Faker\Factory::create();
        $this->guesser      = new Guesser();
        $this->executor     = new StatementExecutor($this->generator, [$this, 'generate']);
        $this->stack        = new GenerationStack();
    }

    /**
     * @param string $className
     * @psalm-param class-string $className
     * @return Property[]
     */
    protected function configure(string $className): array
    {
        $properties = $this->configurator->configureProperties($className);
        $this->guesser->guessMissing($properties);
        foreach ($properties as $property) {
            if ($property->hasStatement()) {
                $property->setCallback($this->executor->execute($property->getStatement()));
            }
        }
        return $properties;
    }

    /**
     * @param string $className
     * @return object|null
     * @throws ReflectionException
     */
    public function generate(string $className)
    {
        if (!class_exists($className)) {
            throw  new InvalidArgumentException("Couldn't load $className");
        }
        $this->stack->push($className);
        if (!$this->stack->valid()) {
            $this->stack->pop();
            return null;
        }
        $config = $this->configure($className);
        $class  = new ReflectionClass($className);
        $obj    = $class->newInstance();
        foreach ($config as $property) {
            $val = $property->getCallback()();
            $property->getRef()->setValue($obj, $val);
        }
        $this->stack->pop();
        return $obj;
    }
}
