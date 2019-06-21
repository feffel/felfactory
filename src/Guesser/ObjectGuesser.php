<?php
declare(strict_types=1);

namespace felfactory\Guesser;

use felfactory\Models\Property;
use felfactory\Statement\Statement;
use felfactory\Statement\StatementFactory;

class ObjectGuesser
{
    /** @var StatementFactory */
    protected $statementFactory;

    protected const FAMOUS_CLASSES
        = [
            'DateTime' => ['factory' => 'makeGenerate', 'args' => ['datetime']],
        ];

    public function __construct()
    {
        $this->statementFactory = new StatementFactory();
    }

    protected function isFamous(string $class): bool
    {
        return array_key_exists($class, self::FAMOUS_CLASSES);
    }

    protected function getPreparedStatement(string $class): Statement
    {
        $prep = self::FAMOUS_CLASSES[$class];
        return $this->statementFactory->{$prep['factory']}(...$prep['args']);
    }

    public function guess(Property $property): void
    {
        if ($property->getType() === null) {
            return;
        }
        if ($this->isFamous($property->getType())) {
            $property->setStatement($this->getPreparedStatement($property->getType()));
        } else {
            $property->setStatement($this->statementFactory->makeClass($property->getType()));
        }
    }
}
