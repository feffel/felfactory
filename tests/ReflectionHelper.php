<?php
declare(strict_types=1);

namespace felfactory\tests;

class ReflectionHelper
{
    public static function set($obj, string $prop, $value): void
    {
        $reflection = new \ReflectionClass($obj);
        $prop       = $reflection->getProperty($prop);
        $prop->setAccessible(true);
        $prop->setValue($obj, $value);
    }

    public static function get($obj, string $prop)
    {
        $reflection = new \ReflectionClass($obj);
        $prop       = $reflection->getProperty($prop);
        $prop->setAccessible(true);

        return $prop->getValue($obj);
    }
}
