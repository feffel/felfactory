<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\ConfigLoader\YamlLoader;
use felfactory\tests\TestModels\SimpleEmbeddedModel;
use PHPUnit\Framework\TestCase;

/**
 * Class PhpLoaderTest
 *
 * @covers  \felfactory\ConfigLoader\PhpLoader
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
        $this->assertEquals([SimpleEmbeddedModel::class], array_keys($configs));
        $this->assertIsArray($configs[SimpleEmbeddedModel::class]);
        $this->assertEquals(['firstName', 'lastName'], array_keys($configs[SimpleEmbeddedModel::class]));
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