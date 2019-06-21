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
     * @psalm-param class-string $className
     * @return Property[]
     */
    public function configureProperties(string $className): array
    {
        $properties = $this->reader->readProperties($className);
        $config     = $this->configLoader->load($className);
        foreach ($config as $propertyName => $propertyConfig) {
            $properties[$propertyName]->statement = (new Parser($propertyConfig))->parse();
        }

        return $properties;
    }
}
