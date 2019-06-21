<?php
declare(strict_types=1);

namespace felfactory\Guesser;

use Faker\Generator;
use Faker\Guesser\Name;
use felfactory\Models\Property;
use felfactory\Statement\StatementFactory;

class PrimitiveGuesser
{
    /** @var StatementFactory */
    protected $statementFactory;

    /** @var Name */
    protected $nameGuesser;

    public function __construct(Generator $generator)
    {
        $this->statementFactory = new StatementFactory();
        $this->nameGuesser      = new Name($generator);
    }

    public function guess(Property $property): void
    {
        $property->setCallback($this->nameGuesser->guessFormat($property->getName()));
    }
}
