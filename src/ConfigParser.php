<?php
/** @noinspection OnlyWritesOnParameterInspection */
/** @noinspection PhpUnusedLocalVariableInspection */
declare(strict_types=1);

namespace felfactory;

use Faker\Generator;

class ConfigParser
{
    protected const CALL_FORMAT = 'return $generator->%s;';

    /** @var Generator */
    protected $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function parse(string $func): callable
    {
        $generator = $this->generator;

        return static function () use ($generator, $func) {
            return eval(sprintf(self::CALL_FORMAT, $func));
        };
    }
}
