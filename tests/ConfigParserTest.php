<?php
declare(strict_types=1);

namespace felfactory\tests;

use Faker\Factory;
use felfactory\ConfigParser;
use PHPUnit\Framework\TestCase;

class ConfigParserTest extends TestCase
{
    public function testFunctionNoArgsNoParentheses(): void
    {
        // SETUP
        $func   = 'firstName';
        $parser = new ConfigParser(Factory::create());
        // TEST
        $callable = $parser->parse($func);
        // ASSERT
        $this->assertIsCallable($callable);
        $this->assertIsString($callable());
    }

    public function testFunctionNoArgsWithParentheses(): void
    {
        // SETUP
        $func   = 'firstName()';
        $parser = new ConfigParser(Factory::create());
        // TEST
        $callable = $parser->parse($func);
        // ASSERT
        $this->assertIsCallable($callable);
        $this->assertIsString($callable());
    }

    public function testFunctionWithArgs(): void
    {
        // SETUP
        $func   = 'firstName("female")';
        $parser = new ConfigParser(Factory::create());
        // TEST
        $callable = $parser->parse($func);
        // ASSERT
        $this->assertIsCallable($callable);
        $this->assertIsString($callable());
    }
}
