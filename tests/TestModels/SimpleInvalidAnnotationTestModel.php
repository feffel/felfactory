<?php
declare(strict_types=1);

namespace felfactory\tests\TestModels;

class SimpleInvalidAnnotationTestModel
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
