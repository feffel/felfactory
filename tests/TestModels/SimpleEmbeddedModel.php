<?php
declare(strict_types=1);

namespace felfactory\tests\TestModels;

use Faker\Generator;
use felfactory\Interfaces\EmbeddedConfig;

class SimpleEmbeddedModel implements EmbeddedConfig
{
    /** @var string */
    public $firstName;

    /** @var string */
    protected $lastName;

    /** @var int */
    private $age;

    public static function config(Generator $generator): array
    {
        return [
            'firstName' => function() use ($generator) {return $generator->firstName;},
            'lastName'  => function() use ($generator) {return $generator->lastName;},
            'age'       => function() use ($generator) {return $generator->numberBetween(18, 59);},
        ];
    }
}
