<?php
declare(strict_types=1);

namespace felfactory\tests\TestModels;
use felfactory\Annotation as Factory;

class SimpleInvalidAnnotationTestModel
{
    /**
     * @Factory\Shape()
     * @var string
     */
    public $firstName;

    /**
     * @Factory\Shape()
     * @var string
     */
    protected $lastName;

    /**
     * @Factory\Shape()
     * @var int
     */
    private $age;
}