<?php
declare(strict_types=1);

namespace felfactory\tests\TestModels;

use Faker\Generator;
use felfactory\Interfaces\StandaloneConfig;

class SimpleTestModelConfig implements StandaloneConfig
{
    public static function config(Generator $generator): array
    {
        return [
            'firstName' => function() use ($generator) {return $generator->firstName;},
            'lastName'  => function() use ($generator) {return $generator->lastName;},
            'age'       => function() use ($generator) {return $generator->numberBetween(18, 59);},
        ];
    }

    public static function dataClass(): string
    {
        return SimpleTestModel::class;
    }
}
