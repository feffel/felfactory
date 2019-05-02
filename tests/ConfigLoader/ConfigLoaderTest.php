<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\ConfigLoader\ConfigLoader;
use felfactory\tests\TestModels\NestedTestModel;
use felfactory\tests\TestModels\SimpleEmbeddedModel;
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
        putenv('ROOT_NAMESPACE=felfactory\tests\TestModels');
        $filePath = __DIR__.'/../TestModels/confs/conf.php';
        putenv("CONFIG_FILE=$filePath");
    }

    public function testLoaderConfigs(): void
    {
        // SETUP
        $loader = new ConfigLoader();
        // TEST
        $conf      = $loader->load(SimpleEmbeddedModel::class);
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
        $conf      = $loader->load(SimpleEmbeddedModel::class);
        // ASSERT
        $this->assertEquals(['firstName', 'lastName', 'age'], array_keys($conf));
    }
}
