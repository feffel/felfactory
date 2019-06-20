<?php
declare(strict_types=1);

namespace felfactory\tests\Parser;

use felfactory\Parser\Parser;
use felfactory\Parser\ParserException;
use felfactory\Statement\StatementType;
use PHPUnit\Framework\TestCase;

/**
 * Class ParserTest
 *
 * @covers  \felfactory\Parser\Parser
 * @covers  \felfactory\Parser\ParserException
 * @package felfactory\tests\Parser
 */
class ParserTest extends TestCase
{
    public function statements(): array
    {
        return [
            ["generate('firstName')", true, StatementType::GENERATE_T],
            ["generate('helloM8')", true, StatementType::GENERATE_T],
            ['generate("firstName")', false],
            ['generate(firstName)', false],
            ["class('\\felfactory\\Parser')", true, StatementType::CLASS_T],
            ["class(\\felfactory\\Parser)", true, StatementType::CLASS_T],
            ["class('firstName')", false],
            ['class(firstName)', false],
            ["value('5 + 4')", true, StatementType::VALUE_T],
            ["value('hello')", true, StatementType::VALUE_T],
            ['value("constant")', false],
            ['value(constant)', false],
            ['value(5 + 4)', false],
            ["many(generate('firstName'), 1, 4)", true, StatementType::MANY_T],
            ["many(class(\\felfactory\\Parser), 2, 5)", true, StatementType::MANY_T],
            ["many(value('5 + 4'), 0, 1)", true, StatementType::MANY_T],
            ["many(many(generate('firstName'), 2, 3), 4 ,5)", true, StatementType::MANY_T],
            ["many('firstName', 3, 4)", false],
            ["many(\\felfactory\\Parser, 5, 7)", false],
            ["many(value('5 + 4'))", false],
            ["many(many(generate('firstName')))", false],
            ['wtf("firstName")', false],
            ['firstName', false],
        ];
    }

    /**
     * @dataProvider statements
     * @param string   $value
     * @param bool     $correct
     * @param int|null $type
     */
    public function testStatement(string $value, bool $correct, string $type = null): void
    {
        $parser = new Parser($value);
        if (!$correct) {
            $this->expectException(ParserException::class);
        }
        $statement = $parser->parse();
        if ($correct) {
            $this->assertEquals($statement->type, $type);
        }
    }

    public function statementsWithArgs(): array
    {
        return [
            ["many(generate('firstName'), 1, 4)", ['from' => 1, 'to' => 4]],
            ["many(class(\\felfactory\\Parser), 2, 5)", ['from' => 2, 'to' => 5]],
            ["many(value('5 + 4'), 0, 999)", ['from' => 0, 'to' => 999]],
            ["many(many(generate('firstName'), 12, 14), 102, 105)", ['from' => 102, 'to' => 105]],
        ];
    }

    /**
     * @dataProvider statementsWithArgs
     * @param $value
     * @param $args
     */
    public function testArgsPassedToStatement($value, $args): void
    {
        $parser    = new Parser($value);
        $statement = $parser->parse();
        $this->assertEquals($args, $statement->args);
    }
}
