<?php
declare(strict_types=1);

namespace felfactory\tests;

use Dotenv\Dotenv;
use Faker\Factory;
use felfactory\ConfigLoader;
use felfactory\tests\TestModels\EmptyTestModel;
use felfactory\tests\TestModels\SimpleEmbeddedModel;
use felfactory\tests\TestModels\SimpleTestModel;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigLoaderTest
 * @covers \felfactory\ConfigLoader
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
        $loader    = new ConfigLoader();
        $generator = Factory::create();
        // TEST
        $config = $loader->load(EmptyTestModel::class)($generator);
        // ASSERT
        $this->assertIsArray($config);
        $this->assertEmpty($config);
    }

    public function testReadStandaloneConfigClass(): void
    {
        // SETUP
        $loader    = new ConfigLoader();
        $generator = Factory::create();
        // TEST
        $config = $loader->load(SimpleTestModel::class)($generator);
        // ASSERT
        $this->assertIsArray($config);
        $this->assertEquals(['firstName', 'lastName', 'age'], array_keys($config));
        $this->assertIsString($config['firstName']);
    }

    public function testReadEmbeddedConfigClass(): void
    {
        // SETUP
        $loader    = new ConfigLoader();
        $generator = Factory::create();
        // TEST
        $config = $loader->load(SimpleEmbeddedModel::class)($generator);
        // ASSERT
        $this->assertIsArray($config);
        $this->assertEquals(['firstName', 'lastName', 'age'], array_keys($config));
        $this->assertIsString($config['firstName']);
    }
}
