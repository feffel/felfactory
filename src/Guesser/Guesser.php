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
            if ($property->primitive === true || $property->type === null) {
                // @TODO add a statement ya baba
                $property->callback = $this->guessPrimitive($property);
            } elseif ($property->primitive === false) {
                // @TODO pull up for primitive array support
                if ($property->isArray()) {
                    $innerStatement      = $this->statementFactory->makeClass($property->type);
                    $property->statement = $this->statementFactory->makeMany($innerStatement, 1, 3);
                } else {
                    $property->statement = $this->statementFactory->makeClass($property->type);
                }
            }
        }
    }

    protected function guessPrimitive(Property $property): ?callable
    {
        return $this->nameGuesser->guessFormat($property->name);
    }
}
