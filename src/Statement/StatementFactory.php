<?php
declare(strict_types=1);

namespace felfactory\Statement;

class StatementFactory
{
    public function makeMany(Statement $innerStatement, int $from, int $to): Statement
    {
        $statement        = new Statement();
        $statement->type  = StatementType::MANY_T;
        $statement->value = $innerStatement;
        $statement->args  = ['from' => $from, 'to'   => $to,];

        return $statement;
    }

    public function makeGenerate(string $generatorLine): Statement
    {
        $statement        = new Statement();
        $statement->type  = StatementType::GENERATE_T;
        $statement->value = $generatorLine;

        return $statement;
    }

    public function makeValue(string $valueLine): Statement
    {
        $statement        = new Statement();
        $statement->type  = StatementType::VALUE_T;
        $statement->value = $valueLine;

        return $statement;
    }

    public function makeClass(string $fqn): Statement
    {
        $statement        = new Statement();
        $statement->type  = StatementType::CLASS_T;
        $statement->value = $fqn;

        return $statement;
    }
}
