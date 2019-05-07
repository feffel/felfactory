<?php
declare(strict_types=1);

namespace felfactory\Parser;

use Doctrine\Common\Lexer\AbstractLexer;

class Lexer extends AbstractLexer
{
    // All tokens that are not valid identifiers must be < 100
    public const T_NONE              = 1;
    public const T_INTEGER           = 2;
    public const T_STRING            = 3;
    public const T_CLOSE_PARENTHESIS = 4;
    public const T_OPEN_PARENTHESIS  = 5;
    public const T_COMMA             = 6;
    public const T_OPEN_CURLY_BRACE  = 7;
    public const T_CLOSE_CURLY_BRACE = 8;
    public const T_AT_SIGN           = 9;
    public const T_HASH              = 10;
    public const T_TILDE             = 11;


    // All tokens that are identifiers or keywords that could be considered as identifiers should be >= 100
    public const T_FULLY_QUALIFIED_NAME = 100;
    public const T_IDENTIFIER           = 101;

    // All keyword tokens should be >= 200
    public const T_CLASS    = 200;
    public const T_GENERATE = 201;
    public const T_VALUE    = 202;
    public const T_MANY     = 203;


    public function __construct(string $input)
    {
        $this->setInput($input);
    }

    protected function getCatchablePatterns(): array
    {
        return [
            '[a-z_][a-z0-9_]*\:[a-z_][a-z0-9_]*(?:\\\[a-z_][a-z0-9_]*)*', // aliased name
            '[a-z_\\\][a-z0-9_]*(?:\\\[a-z_][a-z0-9_]*)*', // identifier or qualified name
            '(?:[0-9]+(?:[\.][0-9]+)*)(?:e[+-]?[0-9]+)?', // numbers
            "'(?:[^']|'')*'", // quoted strings
            '\?[0-9]*|:[a-z_][a-z0-9_]*', // parameters
        ];
    }

    protected function getNonCatchablePatterns(): array
    {
        return ['\s+', '(.)'];
    }

    protected function getType(&$value)
    {
        switch (true) {
            // Recognize numeric values
            case (ctype_digit($value)):
                return self::T_INTEGER;
            // Recognize quoted strings
            case ($value[0] === "'"):
                $value = str_replace("''", "'", substr($value, 1, strlen($value) - 2));

                return self::T_STRING;
            // Recognize identifiers, aliased or qualified names
            case (ctype_alpha($value[0]) || $value[0] === '_' || $value[0] === '\\'):
                $name = 'self::T_'.strtoupper($value);
                if (defined($name)) {
                    $type = constant($name);
                    if ($type >= 200) {
                        return $type;
                    }
                }
                if (strpos($value, '\\') !== false) {
                    return self::T_FULLY_QUALIFIED_NAME;
                }

                return self::T_IDENTIFIER;
            // Recognize symbols
            case ($value === ','):
                return self::T_COMMA;
            case ($value === '('):
                return self::T_OPEN_PARENTHESIS;
            case ($value === ')'):
                return self::T_CLOSE_PARENTHESIS;
            case ($value === '{'):
                return self::T_OPEN_CURLY_BRACE;
            case ($value === '}'):
                return self::T_CLOSE_CURLY_BRACE;
            case ($value === '@'):
                return self::T_AT_SIGN;
            case ($value === '#'):
                return self::T_HASH;
            case ($value === '~'):
                return self::T_TILDE;
            // Default
            default:
                // Do nothing
        }

        return self::T_NONE;
    }
}
