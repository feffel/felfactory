<?php
declare(strict_types=1);

namespace felfactory;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Dotenv\Exception\PathException;

class EnvLoader
{
    private static $loaded = false;

    public static function load(): void
    {
        if (self::$loaded) {
            return;
        }
        try {
            (new Dotenv(true))->load(dirname(__DIR__, 4));
        } catch (PathException $exception) {
        }
        self::$loaded = true;
    }
}
