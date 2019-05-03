<?php
declare(strict_types=1);

namespace felfactory\ConfigLoader;

class ConfigLoader
{
    /** @var array[] */
    protected static $configs = [];

    /** @var AnnotationLoader */
    protected static $annotationLoader;

    /** @var bool */
    protected static $initiated = false;

    public function __construct()
    {
        if (self::$initiated) {
            return;
        }
        $yamlConfigs            = (new YamlLoader())->discover();
        $phpConfigs             = (new PhpLoader())->discover();
        self::$annotationLoader = new AnnotationLoader();
        self::$configs          = array_merge($yamlConfigs, $phpConfigs);
        self::$initiated        = true;
    }

    /**
     * @param string $className
     * @psalm-param  class-string $className
     * @return array
     * @psalm-return array<string, string>
     */
    protected function loadFromAnnotation(string $className): array
    {
        $config = self::$annotationLoader->load($className);
        self::$configs[$className] = $config;
        return $config;
    }

    /**
     * @param string $className
     * @psalm-param  class-string $className
     * @return array
     * @psalm-return array<string, string>
     */
    public function load(string $className): array
    {
        return self::$configs[$className] ?? $this->loadFromAnnotation($className);
    }
}
