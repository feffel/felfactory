<?php
declare(strict_types=1);

namespace felfactory\tests\Models;

use felfactory\Models\Property;
use felfactory\tests\TestModels\SimpleTestModel;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

/**
 * Class PropertyTest
 * @covers \felfactory\Models\Property
 * @package felfactory\tests\Model
 */
class PropertyTest extends TestCase
{
    public function testFromReflection(): void
    {
        // SETUP
        $refProperty = new ReflectionProperty(SimpleTestModel::class, 'firstName');
        // TEST
        $property = Property::fromReflection($refProperty);
        // ASSERT
        $this->assertEquals($refProperty->getName(), $property->name);
        $this->assertEquals(null, $property->type);
        $this->assertSame($refProperty, $property->ref);
    }
}
