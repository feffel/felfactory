<?php
declare(strict_types=1);

namespace felfactory\Guesser;

use felfactory\Models\Property;
use felfactory\Statement\Statement;
use felfactory\Statement\StatementFactory;

class PrimitiveGuesser
{
    /** @var StatementFactory */
    protected $statementFactory;

    /** @var array */
    protected static $NAMES = [];

    /** @var array */
    protected static $TYPES = [];

    public function __construct()
    {
        $this->statementFactory = new StatementFactory();
        if (empty(self::$NAMES)) {
            self::$NAMES = require __DIR__.'/types/byName.php';
        }
        if (empty(self::$TYPES)) {
            self::$TYPES = require __DIR__.'/types/byType.php';
        }
    }

    protected function match(array $names, string $name): ?array
    {
        foreach ($names as $pattern => $value) {
            if (preg_match("/$pattern/i", $name)) {
                return $value;
            }
        }
        return null;
    }

    protected function guessName(string $name): ?Statement
    {
        $variations = $this->match(self::$NAMES, $name);
        if (!$variations) {
            return null;
        }
        $prep = $this->match($variations, $name) ?: $prep = $variations['default'];
        return $this->statementFactory->{$prep['factory']}(...$prep['args']);
    }

    protected function guessByType(string $type): Statement
    {
        $prep = $this->match(self::$TYPES, $type) ?: self::$TYPES['default'];
        return $this->statementFactory->{$prep['factory']}(...$prep['args']);
    }

    public function guess(Property $property): void
    {
        $statement = $this->guessName($property->getName()) ?: $this->guessByType($property->getType());
        $property->setStatement($statement);
    }
}
