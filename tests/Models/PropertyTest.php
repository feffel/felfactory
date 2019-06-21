<?php
declare(strict_types=1);

namespace felfactory\tests\Models;

use felfactory\Models\Property;
use felfactory\Statement\Statement;
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

    public function testSettersAndGetters()
    {
        $refProperty = new ReflectionProperty(SimpleTestModel::class, 'firstName');
        $property = new Property($refProperty);
        $primitive = true;
        $callback = function (): void {};
        $statement = new Statement();
        $type = 'string';
        $name = 'firstName';
        $property->setPrimitive($primitive);
        $property->setCallback($callback);
        $property->setStatement($statement);
        $property->setType($type);
        $property->setName($name);
        $this->assertTrue($property->isConfigured());
        $this->assertTrue($property->hasStatement());
        $this->assertTrue($property->isPrimitive());
        $this->assertSame($callback, $property->getCallback());
        $this->assertSame($statement, $property->getStatement());
        $this->assertSame($type, $property->getType());
        $this->assertSame($name, $property->getName());
    }
}
