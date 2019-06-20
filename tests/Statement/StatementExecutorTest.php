<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\Factory;
use felfactory\Statement\Statement;
use felfactory\Statement\StatementType;
use felfactory\Statement\StatementExecutor;
use felfactory\tests\TestModels\SimpleAnnotatedModel;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class StatementExecutorTest
 * @covers \felfactory\Statement\StatementExecutor
 * @package felfactory\tests
 */
class StatementExecutorTest extends TestCase
{

    protected function getExecutor(): StatementExecutor
    {
        $factory   = new Factory();
        $generator = \Faker\Factory::create();

        return new StatementExecutor($generator, [$factory, 'generate']);
    }

    public function testClassStatement(): void
    {
        // SETUP
        $executor         = $this->getExecutor();
        $statement        = new Statement();
        $statement->type  = StatementType::CLASS_T;
        $statement->value = SimpleAnnotatedModel::class;
        // TEST
        $call   = $executor->execute($statement);
        $result = $call();
        // ASSERT
        $this->assertInstanceOf(SimpleAnnotatedModel::class, $result);
        $this->assertNotEquals($call(), $call());
    }

    public function testValueStatement(): void
    {
        // SETUP
        $executor         = $this->getExecutor();
        $statement        = new Statement();
        $statement->type  = StatementType::VALUE_T;
        $statement->value = '5';
        // TEST
        $result = $executor->execute($statement)();
        // ASSERT
        $this->assertIsInt($result);
        $this->assertEquals(5, $result);
    }

    public function testGenerateStatement(): void
    {
        // SETUP
        $executor         = $this->getExecutor();
        $statement        = new Statement();
        $statement->type  = StatementType::GENERATE_T;
        $statement->value = 'firstName';
        // TEST
        $call   = $executor->execute($statement);
        $result = $call();
        // ASSERT
        $this->assertIsString($result);
        $this->assertNotEquals($call(), $call());
    }

    public function testManyStatement(): void
    {
        // SETUP
        $executor              = $this->getExecutor();
        $innerStatement        = new Statement();
        $innerStatement->type  = StatementType::CLASS_T;
        $innerStatement->value = SimpleAnnotatedModel::class;
        $statement             = new Statement();
        $statement->type       = StatementType::MANY_T;
        $statement->value      = $innerStatement;
        $statement->args       = ['from' => 2, 'to' => 2];
        // TEST
        $call   = $executor->execute($statement);
        $result = $call();
        // ASSERT
        $this->assertIsArray($result);
        foreach ($result as $obj) {
            $this->assertInstanceOf(SimpleAnnotatedModel::class, $obj);
        }
        $this->assertNotEquals($call(), $call());
    }

    public function testErrorOnUndefinedType(): void
    {
        // SETUP
        $executor         = $this->getExecutor();
        $statement        = new Statement();
        $statement->type  = 'undefined';
        $statement->value = SimpleAnnotatedModel::class;
        // ASSERT
        $this->expectException(InvalidArgumentException::class);
        // TEST
        $executor->execute($statement);
    }
}
