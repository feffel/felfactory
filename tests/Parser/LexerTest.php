<?php
declare(strict_types=1);

namespace felfactory\tests\Parser;

use felfactory\Parser\Lexer;
use PHPUnit\Framework\TestCase;

/**
 * Class ShapeLexerTest
 * @covers \felfactory\Parser\Lexer
 * @package felfactory\tests
 */
class LexerTest extends TestCase
{
    public function identifiableSymbols(): array
    {
        return [
            [')', Lexer::T_CLOSE_PARENTHESIS],
            ['(', Lexer::T_OPEN_PARENTHESIS],
            [',', Lexer::T_COMMA],
            ['{', Lexer::T_OPEN_CURLY_BRACE],
            ['}', Lexer::T_CLOSE_CURLY_BRACE],
            ['@', Lexer::T_AT_SIGN],
            ['#', Lexer::T_HASH],
            ['~', Lexer::T_TILDE],
        ];
    }

    /**
     * @dataProvider identifiableSymbols
     * @param string $symbol
     * @param int    $type
     */
    public function testIdentifiableSymbols(string $symbol, int $type): void
    {
        $lexer = new Lexer($symbol);
        $lexer->moveNext();
        $this->assertEquals($type, $lexer->lookahead['type']);
    }

    public function integers(): array
    {
        return [
            ['12', true, 12],
            ['012', true, 12],
            ["h312'", false, null],
            ["'312h'", false, null],
            ['125.895', false, null],
        ];
    }

    /**
     * @dataProvider integers
     * @param string $input
     * @param bool   $isInteger
     * @param int    $value
     */
    public function testIntegers(string $input, bool $isInteger, ?int $value): void
    {
        $lexer = new Lexer($input);
        $lexer->moveNext();
        $token = $lexer->lookahead;
        if ($isInteger) {
            $this->assertEquals(Lexer::T_INTEGER, $token['type']);
            $this->assertEquals($value, $token['value']);
        } else {
            $this->assertNotEquals(Lexer::T_INTEGER, $token['type']);
        }
    }

    public function quotedStrings(): array
    {
        return [
            ['\'hello?\'', true, 'hello?'],
            ["'hello?'", true, 'hello?'],
            ["'124'", true, '124'],
            ['hello?', false, ''],
            ["hell'o", false, ''],
        ];
    }

    /**
     * @dataProvider quotedStrings
     * @param string $input
     * @param bool   $isString
     * @param string $value
     */
    public function testQuotedStrings(string $input, bool $isString, string $value): void
    {
        $lexer = new Lexer($input);
        $lexer->moveNext();
        $token = $lexer->lookahead;
        if ($isString) {
            $this->assertEquals(Lexer::T_STRING, $token['type']);
            $this->assertEquals($value, $token['value']);
        } else {
            $this->assertNotEquals(Lexer::T_STRING, $token['type']);
        }
    }

    public function classNames(): array
    {
        return [
            [self::class, true],
            ['tests\CoolTest', true],
            ["'tests\CoolTest'", false],
            ['ahmed', false],
        ];
    }

    /**
     * @dataProvider classNames
     * @param string $input
     * @param bool   $isClass
     */
    public function testClassNames(string $input, bool $isClass): void
    {
        $lexer = new Lexer($input);
        $lexer->moveNext();
        $token = $lexer->lookahead;
        if ($isClass) {
            $this->assertEquals(Lexer::T_FULLY_QUALIFIED_NAME, $token['type']);
        } else {
            $this->assertNotEquals(Lexer::T_FULLY_QUALIFIED_NAME, $token['type']);
        }
    }

    public function keywords(): array
    {
        return [
            ['class("tests\CoolTest")', Lexer::T_CLASS],
            ['generate("firstName")', Lexer::T_GENERATE],
            ['value("ahmed")', Lexer::T_VALUE],
            ['many(generate("firstName"))', Lexer::T_MANY],
        ];
    }

    /**
     * @dataProvider keywords
     * @param string $input
     * @param int    $type
     */
    public function testKeywords(string $input, int $type): void
    {
        $lexer = new Lexer($input);
        $lexer->moveNext();
        $token = $lexer->lookahead;
        $this->assertEquals($type, $token['type']);
    }
}
