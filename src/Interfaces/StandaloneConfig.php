<?php
declare(strict_types=1);

namespace felfactory\Interfaces;

interface StandaloneConfig extends FactoryConfig
{
    public static function dataClass(): string;
}
