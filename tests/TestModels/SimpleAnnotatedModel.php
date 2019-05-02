<?php
declare(strict_types=1);

namespace felfactory\tests\TestModels;

use felfactory\Annotation as Factory;

class SimpleAnnotatedModel
{
    /**
     * @Factory\Shape("firstName")
     * @var string
     */
    public $firstName;

    /**
     * @Factory\Shape("lastName")
     * @var string
     */
    protected $lastName;

    /**
     * @Factory\Shape("numberBetween(18, 59)")
     * @var int
     */
    private $age;
}
