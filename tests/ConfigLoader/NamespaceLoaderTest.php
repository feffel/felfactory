<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\ConfigLoader\NamespaceLoader;
use felfactory\tests\TestModels\SimpleEmbeddedModel;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigLoaderTest
 *
 * @covers  \felfactory\ConfigLoader\NamespaceLoader
 * @package felfactory\tests
 */
class NamespaceLoaderTest extends TestCase
{
    public function testLoadEmbeddedConfig(): void
    {
        // SETUP
        putenv('ROOT_NAMESPACE=felfactory\tests\TestModels');
        $loader = new NamespaceLoader();
        // TEST
        $configs = $loader->discover();
        // ASSERT
        $this->assertEquals([SimpleEmbeddedModel::class], array_keys($configs));
        $this->assertIsArray($configs[SimpleEmbeddedModel::class]);
        $this->assertEquals(['firstName', 'lastName', 'age'], array_keys($configs[SimpleEmbeddedModel::class]));
    }

    public function testEmptyConfigOnWrongNamespace(): void
    {
        // SETUP
        putenv('ROOT_NAMESPACE=felfactory\tests\TestModels\blah');
        $loader = new NamespaceLoader();
        // TEST
        $configs = $loader->discover();
        // ASSERT
        $this->assertEmpty($configs);
    }
}
