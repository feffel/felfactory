<?php
declare(strict_types=1);

namespace felfactory\tests\Annotation;

use felfactory\Annotation\Generate;
use PHPUnit\Framework\TestCase;

/**
 * Class GenerateTest
 *
 * @covers  \felfactory\Annotation\Generate
 * @package felfactory\tests\Annotation
 */
class GenerateTest extends TestCase
{
    public function testStringify(): void
    {
        // SETUP
        $annotation            = new Generate();
        $annotation->generator = 'firstName';
        // TEST
        $str = $annotation->stringify();
        // ASSERT
        $this->assertEquals("generate('firstName')", $str);
    }

    public function testConfigured(): void
    {
        // SETUP
        $annotation = new Generate();
        // TEST
        $before                = $annotation->isConfigured();
        $annotation->generator = 'firstName';
        $after                 = $annotation->isConfigured();
        // ASSERT
        $this->assertFalse($before);
        $this->assertTrue($after);
    }
}
