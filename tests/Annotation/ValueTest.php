<?php
declare(strict_types=1);

namespace felfactory\tests\Annotation;

use felfactory\Annotation\Value;
use PHPUnit\Framework\TestCase;

/**
 * Class ValueTest
 *
 * @covers  \felfactory\Annotation\Value
 * @package felfactory\tests\Annotation
 */
class ValueTest extends TestCase
{
    public function testStringify(): void
    {
        // SETUP
        $annotation        = new Value();
        $annotation->value = '"felfel"';
        // TEST
        $str = $annotation->stringify();
        // ASSERT
        $this->assertEquals("value('\"felfel\"')", $str);
    }

    public function testConfigured(): void
    {
        // SETUP
        $annotation = new Value();
        // TEST
        $before            = $annotation->isConfigured();
        $annotation->value = "'felfel'";
        $after             = $annotation->isConfigured();
        // ASSERT
        $this->assertFalse($before);
        $this->assertTrue($after);
    }
}
