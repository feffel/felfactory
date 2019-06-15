<?php
declare(strict_types=1);

namespace felfactory\tests\TestModels;

use felfactory\Annotation as Factory;

class SimpleAnnotatedModel
{
    /**
     * @Factory\Shape("generate('firstName')")
     * @var string
     */
    public $firstName;

    /**
     * @Factory\Shape("generate('lastName')")
     * @var string
     */
    protected $lastName;

    /**
     * @Factory\Shape("generate('numberBetween(18, 59)')")
     * @var int
     */
    private $age;
}
