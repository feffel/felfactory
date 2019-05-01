<?php
declare(strict_types=1);

namespace felfactory;

use Dotenv\Dotenv;
use felfactory\Interfaces\FactoryConfig;
use felfactory\Interfaces\StandaloneConfig;
use HaydenPierce\ClassFinder\ClassFinder;

class ConfigLoader
{
    protected const NAMESPACE_VARIABLE = 'ROOT_NAMESPACE';

    /** @var array[] */
    protected static $configs = [];
    /** @var string */
    protected static $rootNamespace;
    /** @var bool */
    protected static $initiated = false;

    public function __construct()
    {
        if (self::$initiated) {
            return;
        }
        $this->loadNamespace();
        $classes       = ClassFinder::getClassesInNamespace(self::$rootNamespace);
        $configClasses = array_filter(
            $classes,
            static function (string $className): bool {
                return is_subclass_of($className, FactoryConfig::class);
            }
        );
        foreach ($configClasses as $configClass) {
            if (is_subclass_of($configClass, StandaloneConfig::class)) {
                /** @noinspection PhpUndefinedMethodInspection */
                $key = $configClass::dataClass();
            } else {
                $key = $configClass;
            }
            /** @noinspection PhpUndefinedMethodInspection */
            self::$configs[$key] = $configClass::config();
        }
        self::$initiated = true;
    }

    protected function loadNamespace(): void
    {
        $namespace = getenv(self::NAMESPACE_VARIABLE);
        if (!$namespace) {
            $dotenv = Dotenv::create(__DIR__.'/../../../');
            $dotenv->load();
            $namespace = getenv(self::NAMESPACE_VARIABLE);
        }
        self::$rootNamespace = $namespace;
    }

    public function load(string $className): array
    {
        return self::$configs[$className] ?? [];
    }
}
