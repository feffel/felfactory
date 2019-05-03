<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\ConfigLoader\ConfigLoader;
use felfactory\tests\TestModels\NestedTestModel;
use felfactory\tests\TestModels\SimpleTestModelPhpConfig;
use felfactory\tests\TestModels\SimpleTestModelYamlConfig;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigLoaderTest
 *
 * @covers  \felfactory\ConfigLoader\ConfigLoader
 * @package felfactory\tests
 */
class ConfigLoaderTest extends TestCase
{
    protected function setUp(): void
    {
        $phpFile = __DIR__.'/../TestModels/confs/conf.php';
        $yamlFile = __DIR__.'/../TestModels/confs/conf.yaml';
        putenv("CONFIG_FILE=$phpFile");
        putenv("YAML_FILE=$yamlFile");
    }

    public function testLoaderConfigs(): void
    {
        // SETUP
        $loader = new ConfigLoader();
        // TEST
        $conf      = $loader->load(SimpleTestModelPhpConfig::class);
        $emptyConf = $loader->load(NestedTestModel::class);
        // ASSERT
        $this->assertEquals(['firstName', 'lastName', 'age'], array_keys($conf));
        $this->assertEmpty($emptyConf);
    }

    public function testConfCached(): void
    {
        // SETUP
        new ConfigLoader();
        putenv('ROOT_NAMESPACE');
        putenv('CONFIG_FILE');
        $loader = new ConfigLoader();
        // TEST
        $conf = $loader->load(SimpleTestModelPhpConfig::class);
        // ASSERT
        $this->assertEquals(['firstName', 'lastName', 'age'], array_keys($conf));
    }

    public function testLoadsAllConfigsInOrder(): void
    {
        // SETUP
        $loader = new ConfigLoader();
        // TEST
        $configs = ReflectionHelper::get($loader, 'configs');
        // ASSERT
        $this->assertEquals([
            SimpleTestModelYamlConfig::class,
            SimpleTestModelPhpConfig::class,
        ], array_keys($configs));
    }
}
