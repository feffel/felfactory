<?php
declare(strict_types=1);

namespace felfactory\Config;

use Spyc;

class YamlLoader
{
    protected function getFile(): string
    {
        return getenv('FACTORY_YAML_FILE') ?: '';
    }

    public function discover(): array
    {
        $file = $this->getFile();
        if (!file_exists($file)) {
            return [];
        }
        $configs = Spyc::YAMLLoad($file);
        $configs = array_filter(
            $configs,
            /**
             * @param mixed  $value
             * @param string|int $key
             * @return bool
             */
            static function ($value, $key): bool {
                return is_array($value) && is_string($key) && class_exists($key);
            },
            ARRAY_FILTER_USE_BOTH
        );

        return $configs;
    }
}
