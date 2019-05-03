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
        $yamlConfigs      = (new YamlLoader())->discover();
        $phpConfigs       = (new PhpLoader())->discover();
        self::$configs    = array_merge($yamlConfigs, $phpConfigs);
        self::$initiated  = true;
    }

    public function load(string $className): array
    {
        return self::$configs[$className] ?? [];
    }
}
