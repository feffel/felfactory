<?php
declare(strict_types=1);

namespace felfactory\ConfigLoader;

use Exception;
use felfactory\Interfaces\EmbeddedConfig;
use HaydenPierce\ClassFinder\ClassFinder;

class NamespaceLoader
{
    /** @deprecated  */
    protected function getNamespace(): string
    {
        // @TODO Replace this with proper configs
        return getenv('ROOT_NAMESPACE') ?: '';
    }

    /**
     * @return array[]
     * @psalm-return array<string, array>
     */
    public function discover(): array
    {
        $namespace = $this->getNamespace();
        try {
            $classes = ClassFinder::getClassesInNamespace($namespace);
        } catch (Exception $e) {
            return [];
        }
        $configClasses = array_filter(
            $classes,
            static function (string $className): bool {
                return is_subclass_of($className, EmbeddedConfig::class);
            }
        );
        $configs       = [];
        foreach ($configClasses as $configClass) {
            $configs[$configClass] = $configClass::config();
        }

        return $configs;
    }
}
