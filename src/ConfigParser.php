<?php
declare(strict_types=1);

namespace felfactory;

use Faker\Generator;

class ConfigParser
{
    /** @var Generator */
    protected $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function parse(string $func): callable
    {
        $this->generator->firstName();
    }
}
