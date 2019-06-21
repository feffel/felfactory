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
            if ($property->isPrimitive() === true || $property->getType() === null) {
                // @TODO add a statement ya baba
                $property->setCallback($this->guessPrimitive($property));
            } elseif ($property->isPrimitive() === false) {
                // @TODO pull up for primitive array support
                if ($property->isArray()) {
                    $innerStatement = $this->statementFactory->makeClass($property->getType());
                    $property->setStatement($this->statementFactory->makeMany($innerStatement, 1, 3));
                } else {
                    $property->setStatement($this->statementFactory->makeClass($property->getType()));
                }
            }
        }
    }

    protected function guessPrimitive(Property $property): ?callable
    {
        return $this->nameGuesser->guessFormat($property->getName());
    }
}
