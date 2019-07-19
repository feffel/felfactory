<?php
declare(strict_types=1);

namespace felfactory\Config;

use felfactory\Models\Property;
use felfactory\Parser\Parser;
use felfactory\Reader;

class Configurator
{
    protected $reader;
    protected $configLoader;

    public function __construct()
    {
        $this->reader       = new Reader();
        $this->configLoader = new ConfigLoader();
    }

    /**
     * @param string $className
     * @param array  $userConfig
     * @return Property[]
     * @psalm-param class-string $className
     */
    public function configureProperties(string $className, array $userConfig = []): array
    {
        $properties = $this->reader->readProperties($className);
        $config     = array_merge($this->configLoader->load($className), $userConfig);
        foreach ($config as $propertyName => $propertyConfig) {
            $properties[$propertyName]->setStatement((new Parser($propertyConfig))->parse());
        }

        return $properties;
    }
}
