<?php
declare(strict_types=1);

namespace felfactory\tests\Config;

use felfactory\Config\ConfigLoader;
use felfactory\Config\Configurator;
use felfactory\Models\Property;
use felfactory\Statement\Statement;
use felfactory\tests\ReflectionHelper;
use felfactory\tests\TestModels\EmptyTestModel;
use felfactory\tests\TestModels\NestedTestModel;
use felfactory\tests\TestModels\SimpleTestModel;
use felfactory\tests\TestModels\SimpleTestModelPhpConfig;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class ConfiguratorTest
 * @covers \felfactory\Config\Configurator
 * @package felfactory\tests\Config
 */
class ConfiguratorTest extends TestCase
{
    protected function setUp(): void
    {
        $phpFile  = __DIR__.'/../TestModels/confs/conf.php';
        $yamlFile = __DIR__.'/../TestModels/confs/conf.yaml';
        putenv("CONFIG_FILE=$phpFile");
        putenv("YAML_FILE=$yamlFile");
    }

    public function testNonExistentClass(): void
    {
        // SETUP
        $configurator = new Configurator();
        // ASSERT
        $this->expectException(ReflectionException::class);
        // TEST
        $configurator->configureProperties('EmptyTestModel');
    }

    public function testEmptyModel(): void
    {
        // SETUP
        $configurator = new Configurator();
        // TEST
        $properties = $configurator->configureProperties(EmptyTestModel::class);
        // ASSERT
        $this->assertIsArray($properties);
        $this->assertEmpty($properties);
    }

    public function testSimpleModel(): void
    {
        // SETUP
        $configurator = new Configurator();
        // TEST
        $properties = $configurator->configureProperties(SimpleTestModel::class);
        // ASSERT
        $this->assertEquals(['firstName', 'lastName', 'age'], array_keys($properties));
        $this->assertInstanceOf(Property::class, reset($properties));
        $this->assertEquals('string', reset($properties)->getType());
    }

    public function testConfiguredModel(): void
    {
        // SETUP
        $configurator = new Configurator();
        // TEST
        $properties = $configurator->configureProperties(SimpleTestModelPhpConfig::class);
        // ASSERT
        $this->assertEquals(['firstName', 'lastName', 'age'], array_keys($properties));
        $this->assertInstanceOf(Property::class, reset($properties));
        $statement = reset($properties)->getStatement();
        $this->assertInstanceOf(Statement::class, $statement);
        $this->assertEquals('firstName', $statement->value);
    }

    public function testNestedModel(): void
    {
        // SETUP
        $configurator = new Configurator();
        // TEST
        $properties = $configurator->configureProperties(NestedTestModel::class);
        // ASSERT
        $this->assertEquals(['simpleObj', 'address'], array_keys($properties));
        $this->assertEquals(SimpleTestModel::class, reset($properties)->getType());
    }

    protected function tearDown(): void
    {
        ReflectionHelper::set(ConfigLoader::class, 'configs', []);
        ReflectionHelper::set(ConfigLoader::class, 'initiated', false);
    }
}
