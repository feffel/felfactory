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

    protected static $configs = [];

    protected static $noConfig;

    protected static $rootNamespace;

    protected static $initiated = false;

    public function __construct()
    {
        if (self::$initiated) {
            return;
        }
        $this->loadNamespace();
        $classes = ClassFinder::getClassesInNamespace(self::$rootNamespace);
        $configClasses = array_filter(
            $classes,
            static function ($className) {
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
            self::$configs[$key] = [$configClass, 'config'];
        }
        self::$noConfig  = static function () {
            return [];
        };
        self::$initiated = true;
    }

    protected function loadNamespace(): void
    {
        $namespace = getenv(self::NAMESPACE_VARIABLE);
        if ($namespace === null) {
            $dotenv = Dotenv::create(__DIR__.'/../../../');
            $dotenv->load();
            $namespace = getenv(self::NAMESPACE_VARIABLE);
        }
        self::$rootNamespace = $namespace;
    }

    public function load(string $className): callable
    {
        if (!isset(self::$configs[$className])) {
            $config = self::$noConfig;
        } else {
            $config = self::$configs[$className];
        }

        return $config;
    }
}
