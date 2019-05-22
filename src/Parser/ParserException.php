<?php
declare(strict_types=1);

namespace felfactory\Parser;

use Exception;
use ReflectionClass;
use Throwable;

class ParserException extends Exception
{
    public function __construct(string $input, array $found, array $expected, $code = 0, Throwable $previous = null)
    {
        $type        = $this->getConstName($found['type']);
        $expected    = array_map([$this, 'getConstName'], $expected);
        $value       = $found['value'];
        $pos         = $found['position'];
        $expectedMsg = strrev(
            implode(
                strrev(' or '),
                explode(strrev(', '), strrev(implode(', ', $expected)), 2)
            )
        );
        $message     = "Error while parsing `$input` at position $pos, Expected $expectedMsg. Found $type '$value'";
        parent::__construct($message, $code, $previous);
    }

    protected function getConstName($value): string
    {
        $class     = new ReflectionClass(Lexer::class);
        $constants = array_flip($class->getConstants());

        return $constants[$value];
    }
}
