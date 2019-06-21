<?php
declare(strict_types=1);

namespace felfactory\tests\Guesser;

use felfactory\Guesser\PrimitiveGuesser;
use felfactory\Models\Property;
use felfactory\tests\TestModels\NestedTestModel;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class PrimitiveGuesserTest
 *
 * @covers  \felfactory\Guesser\PrimitiveGuesser
 * @package felfactory\tests\Guesser
 */
class PrimitiveGuesserTest extends TestCase
{
    public function testGuessFromName(): void
    {
        // SETUP
        $guesser = new PrimitiveGuesser(\Faker\Factory::create());
        $ref     = new ReflectionClass(NestedTestModel::class);
        $address = new Property($ref->getProperty('address'));
        $address->setPrimitive(false);
        $address->setName('address');
        $address->setType('string');
        // TEST
        $guesser->guess($address);
        // ASSERT
        $this->assertIsCallable($address->getCallback());
        $this->assertIsString($address->getCallback()());
    }
}
