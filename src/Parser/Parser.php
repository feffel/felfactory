<?php
declare(strict_types=1);

namespace felfactory\Parser;

use felfactory\Statement\Statement;
use felfactory\Statement\StatementType;

class Parser
{
    /** @var Lexer */
    protected $lexer;

    /** @var string */
    protected $input;

    public function __construct(string $input)
    {
        $this->input = $input;
        $this->lexer = new Lexer($input);
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
        $statement = new Statement();
        switch ($token['type']) {
            case Lexer::T_CLASS:
                $statement->type = StatementType::CLASS_T;
                $this->parseClassStatement($statement);
                break;
            case Lexer::T_GENERATE:
                $statement->type = StatementType::GENERATE_T;
                $this->parseGenerateStatement($statement);
                break;
            case Lexer::T_VALUE:
                $statement->type = StatementType::VALUE_T;
                $this->parseValueStatement($statement);
                break;
            case Lexer::T_MANY:
                $statement->type = StatementType::MANY_T;
                $this->parseManyStatement($statement);
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
     * @param Statement $statement
     * @throws ParserException
     */
    protected function parseClassStatement(Statement $statement): void
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
        $statement->value = $token['value'];
    }

    /**
     * @param Statement $statement
     * @throws ParserException
     */
    protected function parseGenerateStatement(Statement $statement): void
    {
        $this->matchOrThrow(Lexer::T_OPEN_PARENTHESIS);
        $token = $this->matchOrThrow(Lexer::T_STRING);
        $this->matchOrThrow(Lexer::T_CLOSE_PARENTHESIS);
        $statement->value = $token['value'];
    }

    /**
     * @param Statement $statement
     * @throws ParserException
     */
    protected function parseValueStatement(Statement $statement): void
    {
        $this->parseGenerateStatement($statement);
    }

    /**
     * @param Statement $statement
     * @throws ParserException
     */
    protected function parseManyStatement(Statement $statement): void
    {
        $this->matchOrThrow(Lexer::T_OPEN_PARENTHESIS);
        $innerStatement   = $this->parseStatement();
        $statement->value = $innerStatement;
        $this->matchOrThrow(Lexer::T_COMMA);
        $from = $this->matchOrThrow(Lexer::T_INTEGER);
        $this->matchOrThrow(Lexer::T_COMMA);
        $to              = $this->matchOrThrow(Lexer::T_INTEGER);
        $statement->args = [
            'from' => $from['value'],
            'to'   => $to['value'],
        ];
        $this->matchOrThrow(Lexer::T_CLOSE_PARENTHESIS);
    }
}
