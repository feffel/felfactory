<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\ConfigLoader\AnnotationLoader;
use felfactory\tests\TestModels\SimpleAnnotatedModel;
use felfactory\tests\TestModels\SimpleInvalidAnnotationTestModel;
use felfactory\tests\TestModels\SimpleTestModel;
use PHPUnit\Framework\TestCase;

/**
 * Class AnnotationLoaderTest
 *
 * @covers \felfactory\ConfigLoader\AnnotationLoader
 * @package felfactory\tests
 */
class AnnotationLoaderTest extends TestCase
{
    public function testLoadAnnotatedClass(): void
    {
        // SETUP
        $loader = new AnnotationLoader();
        // TEST
        $config = $loader->load(SimpleAnnotatedModel::class);
        // ASSERT
        $this->assertEquals(
            [
                'firstName' => 'firstName',
                'lastName'  => 'lastName',
                'age'       => 'numberBetween(18, 59)',
            ],
            $config
        );
    }

    public function testLoadNoAnnotationClass(): void
    {
        // SETUP
        $loader = new AnnotationLoader();
        // TEST
        $config = $loader->load(SimpleTestModel::class);
        // ASSERT
        $this->assertEmpty($config);
    }

    public function testLoadInvalidAnnotationClass(): void
    {
        // SETUP
        $loader = new AnnotationLoader();
        // TEST
        $config = $loader->load(SimpleInvalidAnnotationTestModel::class);
        // ASSERT
        $this->assertEmpty($config);
    }
}
