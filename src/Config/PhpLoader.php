<?php
declare(strict_types=1);

namespace felfactory\Config;

class PhpLoader
{
    /** @deprecated */
    protected function getFile(): string
    {
        // @TODO Replace this with proper configs
        return getenv('CONFIG_FILE') ?: '';
    }

    /**
     * @return array[]
     * @psalm-return array<string, array>
     */
    public function discover(): array
    {
        $file = $this->getFile();
        if (!file_exists($file)) {
            return [];
        }

        $configs = include $file;
        if (!is_array($configs)) {
            return [];
        }
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
