<?php
declare(strict_types=1);

namespace felfactory\Guesser;

use Faker\Generator;
use Faker\Guesser\Name;
use felfactory\Models\Property;
use felfactory\Statement\StatementFactory;

class Guesser
{
    /** @var Name */
    protected $nameGuesser;

    /** @var StatementFactory */
    protected $statementFactory;


    public function __construct(Generator $generator)
    {
        $this->nameGuesser      = new Name($generator);
        $this->statementFactory = new StatementFactory();
    }

    /**
     * @param Property[] $properties
     */
    public function guessMissing(array $properties): void
    {
        foreach ($properties as $property) {
            if ($property->isPrimitive() === true) {
                // @TODO add a statement ya baba
                $this->guessPrimitive($property);
            } else {
                $this->guessObject($property);
            }
            if ($property->isArray()) {
                $this->wrapInMany($property);
            }
        }
    }

    protected function guessObject(Property $property): void
    {
        // @TODO handle php objects
        if ($property->getType() !== null) {
            $property->setStatement($this->statementFactory->makeClass($property->getType()));
        }
    }

    protected function wrapInMany(Property $property): void
    {
        $property->setStatement($this->statementFactory->makeMany($property->getStatement(), 1, 3));
    }

    protected function guessPrimitive(Property $property): void
    {
        $property->setCallback($this->nameGuesser->guessFormat($property->getName()));
    }
}
