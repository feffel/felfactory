<?php

use felfactory\tests\TestModels\SimpleTestModelPhpConfig;

return [
    SimpleTestModelPhpConfig::class => [
        'firstName' => "generate('firstName')",
        'lastName'  => "generate('lastName')",
        'age'       => "generate('numberBetween(18, 59)')",
    ],
];
