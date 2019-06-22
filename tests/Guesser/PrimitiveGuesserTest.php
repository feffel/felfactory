<?php
declare(strict_types=1);

namespace felfactory\tests\Guesser;

use felfactory\Guesser\PrimitiveGuesser;
use felfactory\Models\Property;
use felfactory\tests\ReflectionHelper;
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
    protected function setUp(): void
    {
        ReflectionHelper::set(PrimitiveGuesser::class, 'NAMES', []);
        ReflectionHelper::set(PrimitiveGuesser::class, 'TYPES', []);
    }

    public function testGuessFromName(): void
    {
        // SETUP
        $guesser = new PrimitiveGuesser();
        $ref     = new ReflectionClass(NestedTestModel::class);
        $address = new Property($ref->getProperty('address'));
        $address->setPrimitive(false);
        $address->setName('lol');
        $address->setType('wtf');
        // TEST
        $guesser->guess($address);
        // ASSERT
        $this->assertTrue($address->hasStatement());
    }
}
