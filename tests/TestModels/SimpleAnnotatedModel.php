<?php
declare(strict_types=1);

namespace felfactory\tests\TestModels;

use felfactory\Annotation as Factory;

class SimpleAnnotatedModel
{
    /**
     * @Factory\Figure("generate('firstName')")
     * @var string
     */
    public $firstName;

    /**
     * @Factory\Figure("generate('lastName')")
     * @var string
     */
    protected $lastName;

    /**
     * @Factory\Figure("generate('numberBetween(18, 59)')")
     * @var int
     */
    private $age;
}
