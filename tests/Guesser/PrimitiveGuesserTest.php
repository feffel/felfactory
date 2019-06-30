<?php
declare(strict_types=1);

namespace felfactory\tests\Guesser;

use felfactory\Guesser\PrimitiveGuesser;
use felfactory\Models\Property;
use felfactory\tests\ReflectionHelper;
use felfactory\tests\TestModels\NestedTestModel;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

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

    public function nameProvider(): array
    {
        return [
            ['CoolAddressMan', 'address'],
            ['boolean', 'boolean'],
            ['name_first', 'firstName'],
            ['AddressMac', 'macAddress'],
            ['countryOfOrigin', 'country'],
            ['workEmail', 'email'],
        ];
    }

    /**
     * @dataProvider nameProvider
     * @param $name
     * @param $guess
     * @throws ReflectionException
     */
    public function testGuessFromName($name, $guess): void
    {
        // SETUP
        $guesser = new PrimitiveGuesser();
        $ref     = new ReflectionClass(NestedTestModel::class);
        $prop = new Property($ref->getProperty('address'));
        $prop->setName($name);
        // TEST
        $guesser->guess($prop);
        // ASSERT
        $this->assertTrue($prop->hasStatement());
        $this->assertEquals($guess, $prop->getStatement()->value);
    }

    public function typeProvider(): array
    {
        return [
            ['str', 'sentence'],
            ['bool', 'boolean'],
            ['int', 'randomNumber'],
            ['array', 'words'],
            ['meh', 'word'],
            [null, null],
        ];
    }

    /**
     * @dataProvider typeProvider
     * @param $type
     * @param $guess
     * @throws ReflectionException
     */
    public function testGuessFromType($type, $guess): void
    {
        // SETUP
        $guesser = new PrimitiveGuesser();
        $ref     = new ReflectionClass(NestedTestModel::class);
        $prop = new Property($ref->getProperty('address'));
        $prop->setName('undefined');
        $prop->setType($type);
        // TEST
        $guesser->guess($prop);
        // ASSERT
        $this->assertTrue($prop->hasStatement());
        $this->assertEquals($guess, $prop->getStatement()->value);
    }
}
