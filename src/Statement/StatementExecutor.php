<?php
declare(strict_types=1);

namespace felfactory\Statement;

use Faker\Generator;
use InvalidArgumentException;

class StatementExecutor
{
    /** @var Generator */
    protected $generator;

    /** @var callable */
    protected $factoryCallback;

    public function __construct(Generator $generator, callable $factoryCallback)
    {
        $this->generator       = $generator;
        $this->factoryCallback = $factoryCallback;
    }

    protected function executeClassStatement(Statement $statement): callable
    {
        $factoryCall = $this->factoryCallback;
        $factoryArg  = $statement->value;

        return static function () use ($factoryCall, $factoryArg) {
            return $factoryCall($factoryArg);
        };
    }

    protected function executeGenerateStatement(Statement $statement): callable
    {
        $generator = $this->generator;
        $func      = $statement->value;

        return static function () use ($generator, $func) {
            return eval(sprintf('return $generator->%s;', $func));
        };
    }

    protected function executeValueStatement(Statement $statement): callable
    {
        $value = $statement->value;

        return static function () use ($value) {
            return eval(sprintf('return %s;', $value));
        };
    }

    protected function executeManyStatement(Statement $statement): callable
    {
        $statementCall = [$this, 'execute'];

        return static function () use ($statementCall, $statement) {
            $result             = [];
            $count              = random_int($statement->args['from'], $statement->args['to']);
            $statementGenerator = $statementCall($statement->value);
            for ($i = 0; $i < $count; $i++) {
                $result[] = $statementGenerator();
            }

            return $result;
        };
    }

    public function execute(Statement $statement): callable
    {
        $call = null;
        switch ($statement->type) {
            case StatementType::CLASS_T:
                $call = $this->executeClassStatement($statement);
                break;
            case StatementType::GENERATE_T:
                $call = $this->executeGenerateStatement($statement);
                break;
            case StatementType::VALUE_T:
                $call = $this->executeValueStatement($statement);
                break;
            case StatementType::MANY_T:
                $call = $this->executeManyStatement($statement);
                break;
            default:
                throw new InvalidArgumentException(sprintf('%s is not a valid StatementType', $statement->type));
        }

        return $call;
    }
}
