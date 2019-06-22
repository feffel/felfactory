<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\Config\ConfigLoader;
use felfactory\Factory;
use felfactory\tests\TestModels\EmptyTestModel;
use felfactory\tests\TestModels\GuessArraysTestModel;
use felfactory\tests\TestModels\NestedTestModel;
use felfactory\tests\TestModels\SimpleTestModel;
use felfactory\tests\TestModels\SimpleTestModelPhpConfig;
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
        $phpFile  = __DIR__.'/TestModels/confs/conf.php';
        $yamlFile = __DIR__.'/TestModels/confs/conf.yaml';
        putenv("CONFIG_FILE=$phpFile");
        putenv("YAML_FILE=$yamlFile");
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

    public function testConfiguredModel(): void
    {
        // SETUP
        $factory = new Factory();
        // TEST
        $obj = $factory->generate(SimpleTestModelPhpConfig::class);
        // ASSERT
        $this->assertInstanceOf(SimpleTestModelPhpConfig::class, $obj);
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

    public function testArraysModel(): void
    {
        // SETUP
        $factory = new Factory();
        // TEST
        $obj = $factory->generate(GuessArraysTestModel::class);
        // ASSERT
        $this->assertIsArray($obj->getCool());
        $this->assertIsArray($obj->getNames());
        $this->assertIsArray($obj->getObjects());
        $this->assertIsArray($obj->getPhoneNumbers());
        $this->assertIsArray($obj->getWhatMate());
    }

    protected function tearDown(): void
    {
        ReflectionHelper::set(ConfigLoader::class, 'configs', []);
        ReflectionHelper::set(ConfigLoader::class, 'initiated', false);
    }
}
