<?php
declare(strict_types=1);

namespace felfactory;

class GenerationStack
{

    protected static $CIRCLE_TOLERANCE;
    protected static $MAX_NEST_LEVEL;

    /** @var array */
    protected $stack = [];

    public function __construct()
    {
        self::$CIRCLE_TOLERANCE = getenv('FACTORY_CIRCLE_TOLERANCE') ?: 1;
        self::$MAX_NEST_LEVEL   = getenv('FACTORY_MAX_NEST_LEVEL') ?: 3;
    }

    public function push(string $className): void
    {
        $this->stack[] = $className;
    }

    public function pop(): void
    {
        array_pop($this->stack);
    }

    public function valid(): bool
    {
        return count($this->stack) <= self::$MAX_NEST_LEVEL
            && max(array_count_values($this->stack)) <= self::$CIRCLE_TOLERANCE;
    }

    public function isEmpty(): bool
    {
        return empty($this->stack);
    }
}
