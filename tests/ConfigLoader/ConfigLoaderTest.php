<?php
declare(strict_types=1);

namespace felfactory\tests;

use Dotenv\Dotenv;
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
        Dotenv::create(__DIR__)->load();
    }

}
