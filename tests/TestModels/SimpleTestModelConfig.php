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
            'firstName' => 'firstName',
            'lastName'  => 'lastName',
            'age'       => 'numberBetween(18, 59)',
        ];
    }

    public static function dataClass(): string
    {
        return SimpleTestModel::class;
    }
}
