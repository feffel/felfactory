<?php
declare(strict_types=1);

namespace felfactory\tests\TestModels;
use felfactory\Annotation as Factory;

class SimpleInvalidAnnotationTestModel
{
    /**
     * @Factory\Figure()
     * @var string
     */
    public $firstName;

    /**
     * @Factory\Figure()
     * @var string
     */
    protected $lastName;

    /**
     * @Factory\Figure()
     * @var int
     */
    private $age;
}
