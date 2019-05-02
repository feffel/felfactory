<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\Factory;
use felfactory\tests\TestModels\EmptyTestModel;
use felfactory\tests\TestModels\NestedTestModel;
use felfactory\tests\TestModels\SimpleEmbeddedModel;
use felfactory\tests\TestModels\SimpleTestModel;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class FactoryTest
 *
 * @covers  \felfactory\Factory
 * @package felfactory\tests
 */
class FactoryTest extends TestCase
{
    protected function setUp(): void
    {
        putenv('ROOT_NAMESPACE=felfactory\tests\TestModels');
    }

    public function testNonExistentClass(): void
    {
        // SETUP
        $factory = new Factory();
        // ASSERT
        $this->expectException(InvalidArgumentException::class);
        // TEST
        $factory->generate('EmptyTestModel');
    }

    public function testEmptyModel(): void
    {
        // SETUP
        $factory = new Factory();
        // TEST
        $obj = $factory->generate(EmptyTestModel::class);
        // ASSERT
        $this->assertInstanceOf(EmptyTestModel::class, $obj);
    }

    public function testSimpleModel(): void
    {
        // SETUP
        $factory = new Factory();
        // TEST
        $obj = $factory->generate(SimpleTestModel::class);
        // ASSERT
        $this->assertInstanceOf(SimpleTestModel::class, $obj);
        $this->assertIsString($obj->firstName);
    }

    public function testSimpleEmbeddedModel(): void
    {
        // SETUP
        $factory = new Factory();
        // TEST
        $obj = $factory->generate(SimpleEmbeddedModel::class);
        // ASSERT
        $this->assertInstanceOf(SimpleEmbeddedModel::class, $obj);
        $this->assertIsString($obj->firstName);
    }

    public function testNestedModel(): void
    {
        // SETUP
        $factory = new Factory();
        // TEST
        $obj = $factory->generate(NestedTestModel::class);
        // ASSERT
        $this->assertInstanceOf(NestedTestModel::class, $obj);
        $this->assertInstanceOf(SimpleTestModel::class, $obj->simpleObj);
        $this->assertIsString($obj->simpleObj->firstName);
        $this->assertIsString($obj->address);
    }
}
