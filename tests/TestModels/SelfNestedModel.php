<?php
declare(strict_types=1);

namespace felfactory\tests\TestModels;

class SelfNestedModel
{
    /** @var string */
    public $name;

    /** @var self */
    public $parent;
}
