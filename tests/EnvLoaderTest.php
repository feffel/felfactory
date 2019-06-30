<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\EnvLoader;
use PHPUnit\Framework\TestCase;

/**
 * Class EnvLoaderTest
 * @covers \felfactory\EnvLoader
 * @package felfactory\tests
 */
class EnvLoaderTest extends TestCase
{
    public function testNoReloading(): void
    {
        // SETUP
        EnvLoader::load();
        // TEST
        EnvLoader::load();
        // ASSERT
        $this->assertTrue(ReflectionHelper::get(EnvLoader::class, 'loaded'));
    }
}
