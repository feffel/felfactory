<?php
declare(strict_types=1);

namespace felfactory;

use Faker\Generator;
use Faker\Guesser\Name;
use felfactory\Models\Property;

class Guesser
{
    /** @var Name */
    protected $nameGuesser;

    /** @var callable */
    protected static $nullProperty;

    public function __construct(Generator $generator)
    {
        $this->nameGuesser = new Name($generator);
        self::$nullProperty = static function () {
            return null;
        };
    }

    public function guess(Property $property): callable
    {
        return $this->nameGuesser->guessFormat($property->name) ?? self::$nullProperty;
    }
}
