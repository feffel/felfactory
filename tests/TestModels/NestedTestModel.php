<?php
declare(strict_types=1);

namespace felfactory\tests\TestModels;

class NestedTestModel
{
    /** @var SimpleTestModel */
    public $simpleObj;

    public $address;
}
