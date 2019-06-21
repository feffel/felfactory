<?php
declare(strict_types=1);

namespace felfactory\Guesser;

use felfactory\Models\Property;
use felfactory\Statement\StatementFactory;

class ObjectGuesser
{
    /** @var StatementFactory */
    protected $statementFactory;

    public function __construct()
    {
        $this->statementFactory = new StatementFactory();
    }

    public function guess(Property $property): void
    {
        // @TODO handle php objects
        if ($property->getType() !== null) {
            $property->setStatement($this->statementFactory->makeClass($property->getType()));
        }
    }
}
