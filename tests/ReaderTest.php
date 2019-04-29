<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\Reader;
use felfactory\tests\TestModels\EmptyTestModel;
use felfactory\tests\TestModels\SimpleTestModel;
use Mockery as m;
use PhpDocReader\PhpDocReader;
use PHPUnit\Framework\TestCase;

/**
 * Class ReaderTest
 *
 * @covers  \felfactory\Reader
 * @package felfactory\tests
 */
class ReaderTest extends TestCase
{
    public function testEmptyModel(): void
    {
        // SETUP
        $reader    = new Reader();
        $docReader = m::mock(PhpDocReader::class);
        $docReader->allows('getPropertyClass')->andReturnValues(['int', 'string']);
        ReflectionHelper::set($reader, 'reader', $docReader);
        // TEST
        $properties = $reader->readProperties(EmptyTestModel::class);
        // ASSERT
        $this->assertIsArray($properties);
        $this->assertEmpty($properties);
    }

    public function testSimpleModel(): void
    {
        // SETUP
        $reader    = new Reader();
        $docReader = m::mock(PhpDocReader::class);
        $docReader->allows('getPropertyClass')->andReturnValues(['int', 'string']);
        ReflectionHelper::set($reader, 'reader', $docReader);
        // TEST
        $properties = $reader->readProperties(SimpleTestModel::class);
        // ASSERT
        $this->assertIsArray($properties);
        $this->assertCount(3, $properties);
        $this->assertEquals(['firstName', 'lastName', 'age'], array_keys($properties));
    }
}
