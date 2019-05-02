<?php
declare(strict_types=1);

namespace felfactory\tests;

use Faker\Guesser\Name;
use felfactory\Guesser;
use felfactory\Models\Property;
use Mockery as m;
use PHPUnit\Framework\TestCase;

/**
 * Class GuesserTest
 *
 * @covers  \felfactory\Guesser
 * @package felfactory\tests
 */
class GuesserTest extends TestCase
{

    public function testNullOnUnknown(): void
    {
        // SETUP
        $guesser = new Guesser(\Faker\Factory::create());
        $name    = m::mock(Name::class);
        $name->allows('guessFormat')->andReturnNull();
        ReflectionHelper::set($guesser, 'nameGuesser', $name);
        $property = m::mock(Property::class);
        // TEST
        $callback = $guesser->guess($property);
        // ASSERT
        $this->assertNull($callback);
    }
}
