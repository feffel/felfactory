<?php
declare(strict_types=1);

namespace felfactory\tests\TestModels;

use felfactory\Annotation as FCT;

class SimpleInvalidAnnotationTestModel
{
    /**
     * @FCT\Generate()
     * @var string
     */
    public $firstName;

    /**
     * @FCT\ObjectOf()
     * @var string
     */
    protected $lastName;

    /**
     * @FCT\ManyOf()
     * @var int
     */
    private $age;
}
