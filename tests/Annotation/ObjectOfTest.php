<?php
declare(strict_types=1);

namespace felfactory\tests\Annotation;

use felfactory\Annotation\ObjectOf;
use PHPUnit\Framework\TestCase;

/**
 * Class ObjectOfTest
 *
 * @covers  \felfactory\Annotation\ObjectOf
 * @package felfactory\tests\Annotation
 */
class ObjectOfTest extends TestCase
{
    public function testStringify(): void
    {
        // SETUP
        $annotation        = new ObjectOf();
        $annotation->class = self::class;
        // TEST
        $str = $annotation->stringify();
        // ASSERT
        $expects = sprintf('class(%s)', self::class);
        $this->assertEquals($expects, $str);
    }

    public function testConfigured(): void
    {
        // SETUP
        $annotation = new ObjectOf();
        // TEST
        $before            = $annotation->isConfigured();
        $annotation->class = self::class;
        $after             = $annotation->isConfigured();
        // ASSERT
        $this->assertFalse($before);
        $this->assertTrue($after);
    }
}
