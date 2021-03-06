<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\Config\PhpLoader;
use felfactory\tests\TestModels\SimpleTestModelPhpConfig;
use PHPUnit\Framework\TestCase;

/**
 * Class PhpLoaderTest
 *
 * @covers  \felfactory\Config\PhpLoader
 * @package felfactory\tests
 */
class PhpLoaderTest extends TestCase
{
    public function testLoadPhpConfig(): void
    {
        // SETUP
        $filePath = __DIR__.'/../TestModels/confs/conf.php';
        putenv("FACTORY_PHP_FILE=$filePath");
        $loader = new PhpLoader();
        // TEST
        $configs = $loader->discover();
        // ASSERT
        $this->assertEquals([SimpleTestModelPhpConfig::class], array_keys($configs));
        $this->assertIsArray($configs[SimpleTestModelPhpConfig::class]);
        $this->assertEquals(['firstName', 'lastName', 'age'], array_keys($configs[SimpleTestModelPhpConfig::class]));
    }

    public function invalidConf(): array
    {
        return [
            'DoesNotExist'       => [__DIR__.'/../TestModels/confs/lol.text'],
            'ReturnInvalidArray' => [__DIR__.'/../TestModels/confs/invalid_conf.php'],
            'NoReturn'           => [__DIR__.'/../TestModels/confs/invalid_conf2.php'],
        ];
    }

    /**
     * @dataProvider invalidConf
     * @param string $filePath
     */
    public function testEmptyOnInvalidConfig(string $filePath): void
    {
        // SETUP
        putenv("FACTORY_PHP_FILE=$filePath");
        $loader = new PhpLoader();
        // TEST
        $configs = $loader->discover();
        // ASSERT
        $this->assertEmpty($configs);
    }
}
