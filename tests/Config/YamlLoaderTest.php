<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\Config\YamlLoader;
use felfactory\tests\TestModels\SimpleTestModelYamlConfig;
use PHPUnit\Framework\TestCase;

/**
 * Class YamlLoaderTest
 *
 * @covers \felfactory\Config\YamlLoader
 * @package felfactory\tests
 */
class YamlLoaderTest extends TestCase
{
    public function testLoadPhpConfig(): void
    {
        // SETUP
        $filePath = __DIR__.'/../TestModels/confs/conf.yaml';
        putenv("YAML_FILE=$filePath");
        $loader = new YamlLoader();
        // TEST
        $configs = $loader->discover();
        // ASSERT
        $this->assertEquals([SimpleTestModelYamlConfig::class], array_keys($configs));
        $this->assertIsArray($configs[SimpleTestModelYamlConfig::class]);
        $this->assertEquals(['firstName', 'lastName', 'age'], array_keys($configs[SimpleTestModelYamlConfig::class]));
    }

    public function invalidConf(): array
    {
        return [
            'DoesNotExist'      => [__DIR__.'/../TestModels/confs/lol.yaml'],
            'ReturnArrayFormat' => [__DIR__.'/../TestModels/confs/invalid_conf.php'],
        ];
    }

    /**
     * @dataProvider invalidConf
     * @param string $filePath
     */
    public function testEmptyOnInvalidConfig(string $filePath): void
    {
        // SETUP
        putenv("YAML_FILE=$filePath");
        $loader = new YamlLoader();
        // TEST
        $configs = $loader->discover();
        // ASSERT
        $this->assertEmpty($configs);
    }
}
