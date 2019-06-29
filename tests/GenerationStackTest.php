<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\GenerationStack;
use PHPUnit\Framework\TestCase;

/**
 * Class GenerationStackTest
 * @covers \felfactory\GenerationStack
 * @package felfactory\tests
 */
class GenerationStackTest extends TestCase
{
    public function testSelfReference(): void
    {
        // SETUP
        $stack = new GenerationStack();
        $stack->push('A');
        $stack->push('A');
        $stack->push('A');
        // TEST
        $valid = $stack->valid();
        // ASSERT
        $this->assertFalse($valid);
    }

    public function testCircularReferenceAllowance(): void
    {
        // SETUP
        $stack = new GenerationStack();
        $stack->push('A');
        $stack->push('B');
        $stack->push('A');
        $stack->push('B');
        // TEST
        $valid = $stack->valid();
        // ASSERT
        $this->assertTrue($valid);
    }

    public function testLongCircularReference(): void
    {
        // SETUP
        $stack = new GenerationStack();
        $stack->push('A');
        $stack->push('B');
        $stack->push('C');
        $stack->push('D');
        $stack->push('A');
        $stack->push('B');
        $stack->push('C');
        $stack->push('D');
        $stack->push('A');
        // TEST
        $valid = $stack->valid();
        // ASSERT
        $this->assertFalse($valid);
    }

    public function testLateCircularReference(): void
    {
        // SETUP
        $stack = new GenerationStack();
        $stack->push('A');
        $stack->push('B');
        $stack->push('C');
        $stack->push('D');
        $stack->push('C');
        $stack->push('D');
        $stack->push('C');
        // TEST
        $valid = $stack->valid();
        // ASSERT
        $this->assertFalse($valid);
    }

    public function testArrayGenerationBehaviour(): void
    {
        // SETUP
        $stack = new GenerationStack();
        $stack->push('A');
        $stack->push('B');
        $stack->pop();
        $stack->push('B');
        $stack->pop();
        $stack->push('B');
        $stack->pop();
        // TEST
        $valid = $stack->valid();
        // ASSERT
        $this->assertTrue($valid);
    }

    public function testEmptiness(): void
    {
        // SETUP
        $stack = new GenerationStack();
        $stack->push('A');
        $stack->push('B');
        $stack->pop();
        // TEST
        $empty = $stack->isEmpty();
        // ASSERT
        $this->assertFalse($empty);
        // TEST
        $stack->pop();
        $empty = $stack->isEmpty();
        // ASSERT
        $this->assertTrue($empty);
    }
}
