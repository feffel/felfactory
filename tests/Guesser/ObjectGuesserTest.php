<?php
declare(strict_types=1);

namespace felfactory\tests\Guesser;

use DateTime;
use felfactory\Guesser\ObjectGuesser;
use felfactory\Models\Property;
use felfactory\Statement\StatementType;
use felfactory\tests\TestModels\NestedTestModel;
use felfactory\tests\TestModels\SimpleTestModel;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class ObjectGuesser
 *
 * @covers  \felfactory\Guesser\ObjectGuesser
 * @package felfactory\tests\Guesser
 */
class ObjectGuesserTest extends TestCase
{

    public function testNullType(): void
    {
        // SETUP
        $guesser   = new ObjectGuesser();
        $ref       = new ReflectionClass(NestedTestModel::class);
        $simpleObj = new Property($ref->getProperty('simpleObj'));
        $simpleObj->setPrimitive(false);
        // TEST
        $guesser->guess($simpleObj);
        // ASSERT
        $this->assertFalse($simpleObj->hasStatement());
    }

    public function testGuessObjectsFromType(): void
    {
        // SETUP
        $guesser   = new ObjectGuesser();
        $ref       = new ReflectionClass(NestedTestModel::class);
        $simpleObj = new Property($ref->getProperty('simpleObj'));
        $simpleObj->setPrimitive(false);
        $simpleObj->setType(SimpleTestModel::class);
        // TEST
        $guesser->guess($simpleObj);
        // ASSERT
        $this->assertEquals(StatementType::CLASS_T, $simpleObj->getStatement()->type);
        $this->assertEquals(SimpleTestModel::class, $simpleObj->getStatement()->value);
    }

    public function testFamousClassDateTime(): void
    {
        // SETUP
        $guesser   = new ObjectGuesser();
        $ref       = new ReflectionClass(NestedTestModel::class);
        $simpleObj = new Property($ref->getProperty('simpleObj'));
        $simpleObj->setPrimitive(false);
        $simpleObj->setType(DateTime::class);
        // TEST
        $guesser->guess($simpleObj);
        // ASSERT
        $this->assertEquals(StatementType::GENERATE_T, $simpleObj->getStatement()->type);
        $this->assertEquals('datetime', $simpleObj->getStatement()->value);
    }
}
