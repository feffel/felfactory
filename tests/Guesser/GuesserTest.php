<?php
declare(strict_types=1);

namespace felfactory\tests;

use felfactory\Guesser\Guesser;
use felfactory\Models\Property;
use felfactory\Statement\Statement;
use felfactory\Statement\StatementType;
use felfactory\tests\TestModels\NestedTestModel;
use felfactory\tests\TestModels\SimpleTestModel;
use felfactory\tests\TestModels\SimpleTestModelPhpConfig;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class GuesserTest
 *
 * @covers  \felfactory\Guesser\Guesser
 * @package felfactory\tests
 */
class GuesserTest extends TestCase
{
    public function testAllMissingFilled(): void
    {
        // SETUP
        $guesser   = new Guesser();
        $ref       = new ReflectionClass(SimpleTestModelPhpConfig::class);
        $firstName = new Property($ref->getProperty('firstName'));
        $lastName  = new Property($ref->getProperty('lastName'));
        $age       = new Property($ref->getProperty('lastName'));
        $preConf   = new Statement();
        $firstName->setPrimitive(true);
        $lastName->setPrimitive(true);
        $age->setStatement($preConf);
        // TEST
        $guesser->guessMissing([$firstName, $lastName, $age]);
        // ASSERT
        $this->assertTrue($firstName->hasStatement());
        $this->assertTrue($lastName->hasStatement());
        $this->assertSame($preConf, $age->getStatement());
    }

    public function testGuessArrayOfObjects(): void
    {
        // SETUP
        $guesser   = new Guesser();
        $ref       = new ReflectionClass(NestedTestModel::class);
        $simpleObj = new Property($ref->getProperty('simpleObj'));
        $simpleObj->setPrimitive(false);
        $simpleObj->setType(SimpleTestModel::class.'[]');
        // TEST
        $guesser->guessMissing([$simpleObj]);
        // ASSERT
        $this->assertTrue($simpleObj->hasStatement());
        $this->assertEquals(StatementType::MANY_T, $simpleObj->getStatement()->type);
        $this->assertInstanceOf(Statement::class, $simpleObj->getStatement()->value);
        $this->assertEquals(SimpleTestModel::class, $simpleObj->getStatement()->value->value);
    }
}
