<?php
declare(strict_types=1);

namespace felfactory\tests\Statement;

use felfactory\Statement\Statement;
use felfactory\Statement\StatementFactory;
use felfactory\Statement\StatementType;
use PHPUnit\Framework\TestCase;

/**
 * Class StatementFactoryTest
 *
 * @covers  \felfactory\Statement\StatementFactory
 * @package felfactory\tests\Statement
 */
class StatementFactoryTest extends TestCase
{
    public function testMakeGenerate(): void
    {
        // SETUP
        $generate = 'firstName';
        $factory  = new StatementFactory();
        // TEST
        $result = $factory->makeGenerate($generate);
        // ASSERT
        $this->assertEquals($result->type, StatementType::GENERATE_T);
        $this->assertEquals($result->value, $generate);
    }

    public function testMakeValue(): void
    {
        // SETUP
        $value   = '5 + 3';
        $factory = new StatementFactory();
        // TEST
        $result = $factory->makeValue($value);
        // ASSERT
        $this->assertEquals($result->type, StatementType::VALUE_T);
        $this->assertEquals($result->value, $value);
    }

    public function testMakeClass(): void
    {
        // SETUP
        $fqn     = self::class;
        $factory = new StatementFactory();
        // TEST
        $result = $factory->makeClass($fqn);
        // ASSERT
        $this->assertEquals($result->type, StatementType::CLASS_T);
        $this->assertEquals($result->value, $fqn);
    }

    public function testMakeMany(): void
    {
        // SETUP
        $inner   = new Statement();
        $factory = new StatementFactory();
        // TEST
        $result = $factory->makeMany($inner, 1, 3);
        // ASSERT
        $this->assertEquals($result->type, StatementType::MANY_T);
        $this->assertEquals($result->value, $inner);
        $this->assertEquals($result->args, ['from' => 1, 'to' => 3]);
    }

    public function testMakeNull(): void
    {
        // SETUP
        $factory = new StatementFactory();
        // TEST
        $result = $factory->makeNull();
        // ASSERT
        $this->assertEquals($result->type, StatementType::NULL_T);
        $this->assertNull($result->value);
        $this->assertNull($result->args);
    }
}
