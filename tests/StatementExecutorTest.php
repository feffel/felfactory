<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\Factory;
use felfactory\Parser\Statement;
use felfactory\Parser\StatementType;
use felfactory\StatementExecutor;
use felfactory\tests\TestModels\SimpleAnnotatedModel;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

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
        $executor        = $this->getExecutor();
        $statment        = new Statement();
        $statment->type  = StatementType::CLASS_T;
        $statment->value = SimpleAnnotatedModel::class;
        // TEST
        $call   = $executor->execute($statment);
        $result = $call();
        // ASSERT
        $this->assertInstanceOf(SimpleAnnotatedModel::class, $result);
        $this->assertNotEquals($call(), $call());
    }

    public function testValueStatement(): void
    {
        // SETUP
        $executor        = $this->getExecutor();
        $statment        = new Statement();
        $statment->type  = StatementType::VALUE_T;
        $statment->value = '5';
        // TEST
        $result = $executor->execute($statment)();
        // ASSERT
        $this->assertIsInt($result);
        $this->assertEquals(5, $result);
    }

    public function testGenerateStatement(): void
    {
        // SETUP
        $executor        = $this->getExecutor();
        $statment        = new Statement();
        $statment->type  = StatementType::GENERATE_T;
        $statment->value = 'firstName';
        // TEST
        $call   = $executor->execute($statment);
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
        $statment              = new Statement();
        $statment->type        = StatementType::MANY_T;
        $statment->value       = $innerStatement;
        $statment->args        = ['from' => 2, 'to' => 2];
        // TEST
        $call   = $executor->execute($statment);
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
        $executor        = $this->getExecutor();
        $statment        = new Statement();
        $statment->type  = 'undefined';
        $statment->value = SimpleAnnotatedModel::class;
        // ASSERT
        $this->expectException(InvalidArgumentException::class);
        // TEST
        $executor->execute($statment);
    }
}
