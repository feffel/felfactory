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

    public static function config(): array
    {
        return [
            'firstName' => 'firstName',
            'lastName'  => 'lastName',
            'age'       => 'numberBetween(18, 59)',
        ];
    }
}
