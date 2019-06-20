<?php
declare(strict_types=1);

namespace felfactory\Parser;

use felfactory\Statement\Statement;
use felfactory\Statement\StatementFactory;

class Parser
{
    /** @var Lexer */
    protected $lexer;

    /** @var StatementFactory */
    protected $factory;

    /** @var string */
    protected $input;

    public function __construct(string $input)
    {
        $this->input   = $input;
        $this->lexer   = new Lexer($input);
        $this->factory = new StatementFactory();
    }

    public function parse(): Statement
    {
        $this->lexer->reset();
        return $this->parseStatement();
    }

    /**
     * @param int $type
     * @return array
     * @throws ParserException
     */
    protected function matchOrThrow(int $type): array
    {
        $this->lexer->moveNext();
        $token = $this->lexer->lookahead;
        if ($token['type'] !== $type) {
            throw new ParserException($this->input, $token, [$type]);
        }

        return $token;
    }

    /**
     * @return Statement
     * @throws ParserException
     */
    protected function parseStatement(): Statement
    {
        $this->lexer->moveNext();
        $token     = $this->lexer->lookahead;
        switch ($token['type']) {
            case Lexer::T_CLASS:
                $statement = $this->parseClassStatement();
                break;
            case Lexer::T_GENERATE:
                $statement = $this->parseGenerateStatement();
                break;
            case Lexer::T_VALUE:
                $statement = $this->parseValueStatement();
                break;
            case Lexer::T_MANY:
                $statement = $this->parseManyStatement();
                break;
            default:
                throw new ParserException(
                    $this->input,
                    $token,
                    [Lexer::T_CLASS, Lexer::T_GENERATE, Lexer::T_VALUE, Lexer::T_MANY]
                );
        }

        return $statement;
    }

    /**
     *
     * @return Statement
     * @throws ParserException
     */
    protected function parseClassStatement(): Statement
    {
        $this->matchOrThrow(Lexer::T_OPEN_PARENTHESIS);
        $this->lexer->moveNext();
        $token = $this->lexer->lookahead;
        if ($token['type'] !== Lexer::T_FULLY_QUALIFIED_NAME
            && !$this->lexer->isA(
                $token['value'],
                Lexer::T_FULLY_QUALIFIED_NAME
            )) {
            throw new ParserException($this->input, $token, [Lexer::T_FULLY_QUALIFIED_NAME]);
        }
        $this->matchOrThrow(Lexer::T_CLOSE_PARENTHESIS);
        return $this->factory->makeClass($token['value']);
    }

    /**
     * @return Statement
     * @throws ParserException
     */
    protected function parseGenerateStatement(): Statement
    {
        $this->matchOrThrow(Lexer::T_OPEN_PARENTHESIS);
        $token = $this->matchOrThrow(Lexer::T_STRING);
        $this->matchOrThrow(Lexer::T_CLOSE_PARENTHESIS);
        return $this->factory->makeGenerate($token['value']);
    }

    /**
     * @return Statement
     * @throws ParserException
     */
    protected function parseValueStatement(): Statement
    {
        $this->matchOrThrow(Lexer::T_OPEN_PARENTHESIS);
        $token = $this->matchOrThrow(Lexer::T_STRING);
        $this->matchOrThrow(Lexer::T_CLOSE_PARENTHESIS);
        return $this->factory->makeValue($token['value']);
    }

    /**
     * @return Statement
     * @throws ParserException
     */
    protected function parseManyStatement(): Statement
    {
        $this->matchOrThrow(Lexer::T_OPEN_PARENTHESIS);
        $innerStatement = $this->parseStatement();
        $this->matchOrThrow(Lexer::T_COMMA);
        $from = $this->matchOrThrow(Lexer::T_INTEGER);
        $this->matchOrThrow(Lexer::T_COMMA);
        $to = $this->matchOrThrow(Lexer::T_INTEGER);
        $this->matchOrThrow(Lexer::T_CLOSE_PARENTHESIS);
        return $this->factory->makeMany($innerStatement, (int)$from['value'], (int)$to['value']);
    }
}
