<?php
declare(strict_types=1);

namespace felfactory\Interfaces;

use Faker\Generator;

interface FactoryConfig
{
    public static function config(Generator $generator): array;
}
