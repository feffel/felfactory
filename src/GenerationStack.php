<?php
declare(strict_types=1);

namespace felfactory;

class GenerationStack
{
    protected const CIRCLE_TOLERANCE = 2;
    protected const MAX_NEST_LEVEL   = 10;

    /** @var array */
    protected $stack = [];

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
        return count($this->stack) <= self::MAX_NEST_LEVEL
            && max(array_count_values($this->stack)) <= self::CIRCLE_TOLERANCE;
    }

    public function isEmpty(): bool
    {
        return empty($this->stack);
    }
}
