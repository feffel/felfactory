<?php
declare(strict_types=1);

namespace felfactory\Guesser;

use Faker\Generator;
use felfactory\Models\Property;
use felfactory\Statement\StatementFactory;

class Guesser
{
    /** @var ObjectGuesser */
    protected $objectGuesser;

    /** @var PrimitiveGuesser */
    protected $primitiveGuesser;

    /** @var StatementFactory */
    protected $statementFactory;


    public function __construct(Generator $generator)
    {
        $this->objectGuesser    = new ObjectGuesser();
        $this->primitiveGuesser = new PrimitiveGuesser($generator);
        $this->statementFactory = new StatementFactory();
    }

    /**
     * @param Property[] $properties
     */
    public function guessMissing(array $properties): void
    {
        foreach ($properties as $property) {
            if (!$property->isConfigured()) {
                $this->guess($property);
            }
            if ($property->isArray()) {
                $this->wrapInMany($property);
            }
        }
    }

    public function guess(Property $property): void
    {
        if ($property->isPrimitive() === true) {
            // @TODO add a statement ya baba
            $this->primitiveGuesser->guess($property);
        } else {
            $this->objectGuesser->guess($property);
        }
    }

    protected function wrapInMany(Property $property): void
    {
        $property->setStatement($this->statementFactory->makeMany($property->getStatement(), 1, 3));
    }
}
