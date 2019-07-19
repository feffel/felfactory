<?php
declare(strict_types=1);

namespace felfactory\tests\Annotation;

use felfactory\Annotation\Generate;
use felfactory\Annotation\ManyOf;
use PHPUnit\Framework\TestCase;

/**
 * Class ManyOfTest
 *
 * @covers  \felfactory\Annotation\ManyOf
 * @package felfactory\tests\Annotation
 */
class ManyOfTest extends TestCase
{
    public function testStringify(): void
    {
        // SETUP
        $annotation                    = new ManyOf();
        $annotation->figure            = new Generate();
        $annotation->figure->generator = 'firstName';
        // TEST
        $str = $annotation->stringify();
        // ASSERT
        $this->assertEquals("many(generate('firstName'), 0, 3)", $str);
    }

    public function testConfigured(): void
    {
        // SETUP
        $annotation = new ManyOf();
        // TEST
        $before             = $annotation->isConfigured();
        $annotation->figure = new Generate();
        $after              = $annotation->isConfigured();
        // ASSERT
        $this->assertFalse($before);
        $this->assertTrue($after);
    }
}
