<?php
declare(strict_types=1);

namespace felfactory\ConfigLoader;

class ConfigLoader
{
    /** @var array[] */
    protected static $configs = [];

    /** @var bool */
    protected static $initiated = false;

    public function __construct()
    {
        if (self::$initiated) {
            return;
        }
        $namespaceConfigs = (new NamespaceLoader())->discover();
        self::$configs    = $namespaceConfigs;
        self::$initiated  = true;
    }

    public function load(string $className): array
    {
        return self::$configs[$className] ?? [];
    }
}
