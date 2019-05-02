<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\ConfigLoader\PhpLoader;
use felfactory\tests\TestModels\SimpleEmbeddedModel;
use PHPUnit\Framework\TestCase;

/**
 * Class PhpLoaderTest
 *
 * @covers  \felfactory\ConfigLoader\PhpLoader
 * @package felfactory\tests
 */
class PhpLoaderTest extends TestCase
{
    public function testLoadPhpConfig(): void
    {
        // SETUP
        $filePath = __DIR__.'/../TestModels/conf.php';
        putenv("CONFIG_FILE=$filePath");
        $loader = new PhpLoader();
        // TEST
        $configs = $loader->discover();
        // ASSERT
        $this->assertEquals([SimpleEmbeddedModel::class], array_keys($configs));
        $this->assertIsArray($configs[SimpleEmbeddedModel::class]);
        $this->assertEquals(['firstName', 'lastName'], array_keys($configs[SimpleEmbeddedModel::class]));
    }

    public function testEmptyOnFileDoesNotExist(): void
    {
        // SETUP
        $filePath = __DIR__.'../TestModels/lol.text';
        putenv("CONFIG_FILE=$filePath");
        $loader = new PhpLoader();
        // TEST
        $configs = $loader->discover();
        // ASSERT
        $this->assertEmpty($configs);
    }

    public function invalidConf(): array
    {
        return [
            'DoesNotExist'       => [__DIR__.'/../TestModels/lol.text'],
            'ReturnInvalidArray' => [__DIR__.'/../TestModels/invalid_conf.php'],
            'NoReturn'           => [__DIR__.'/../TestModels/invalid_conf2.php'],
        ];
    }

    /**
     * @dataProvider invalidConf
     * @param string $filePath
     */
    public function testEmptyOnInvalidConfigFormat(string $filePath): void
    {
        // SETUP
        putenv("CONFIG_FILE=$filePath");
        $loader = new PhpLoader();
        // TEST
        $configs = $loader->discover();
        // ASSERT
        $this->assertEmpty($configs);
    }
}
