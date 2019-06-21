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
    public function testConstruction(): void
    {
        // SETUP
        $refProperty = new ReflectionProperty(SimpleTestModel::class, 'firstName');
        // TEST
        $property = new Property($refProperty);
        // ASSERT
        $this->assertEquals($refProperty->getName(), $property->getName());
        $this->assertEquals(null, $property->getType());
        $this->assertSame($refProperty, $property->getRef());
    }

    public function testArrayNoType(): void
    {
        // SETUP
        $refProperty = new ReflectionProperty(SimpleTestModel::class, 'firstName');
        // TEST
        $property = new Property($refProperty);
        $isArray = $property->isArray();
        // ASSERT
        $this->assertFalse($isArray);
        $this->assertNull($property->getType());
    }

    public function testArrayType(): void
    {
        // SETUP
        $refProperty = new ReflectionProperty(SimpleTestModel::class, 'firstName');
        // TEST
        $property = new Property($refProperty);
        $property->setType('string');
        $isArray = $property->isArray();
        // ASSERT
        $this->assertFalse($isArray);
        $this->assertEquals('string', $property->getType());
    }

    public function testNotArrayType(): void
    {
        // SETUP
        $refProperty = new ReflectionProperty(SimpleTestModel::class, 'firstName');
        // TEST
        $property = new Property($refProperty);
        $property->setType('string[]');
        $isArray = $property->isArray();
        // ASSERT
        $this->assertTrue($isArray);
        $this->assertEquals('string', $property->getType());
    }
}
