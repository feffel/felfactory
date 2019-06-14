<?php
declare(strict_types=1);

namespace felfactory\Parser;

class StatementType
{
    private function __construct()
    {
    }

    public const CLASS_T    = 'class';
    public const GENERATE_T = 'generate';
    public const VALUE_T    = 'value';
    public const MANY_T     = 'many';
}
