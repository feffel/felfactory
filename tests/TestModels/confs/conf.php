<?php

use felfactory\tests\TestModels\SimpleTestModelPhpConfig;

return [
    SimpleTestModelPhpConfig::class => [
        'firstName' => 'firstName',
        'lastName'  => 'lastName',
        'age'       => 'numberBetween(18, 59)',
    ],
];
