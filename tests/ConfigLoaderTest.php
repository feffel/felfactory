<?php
declare(strict_types=1);

namespace felfactory\tests;

use Dotenv\Dotenv;
use felfactory\ConfigLoader;
use felfactory\tests\TestModels\EmptyTestModel;
use felfactory\tests\TestModels\SimpleEmbeddedModel;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigLoaderTest
 *
 * @covers  \felfactory\ConfigLoader
 * @package felfactory\tests
 */
class ConfigLoaderTest extends TestCase
{
    protected function setUp(): void
    {
        Dotenv::create(__DIR__)->load();
    }

    public function testReadNoConfigClass(): void
    {
        // SETUP
        $loader = new ConfigLoader();
        // TEST
        $config = $loader->load(EmptyTestModel::class);
        // ASSERT
        $this->assertIsArray($config);
        $this->assertEmpty($config);
    }

    public function testReadEmbeddedConfigClass(): void
    {
        // SETUP
        $loader = new ConfigLoader();
        // TEST
        $config = $loader->load(SimpleEmbeddedModel::class);
        // ASSERT
        $this->assertIsArray($config);
        $this->assertEquals(['firstName', 'lastName', 'age'], array_keys($config));
        $this->assertIsString($config['firstName']);
    }
}
