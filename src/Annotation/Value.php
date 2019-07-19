<?php
declare(strict_types=1);

namespace felfactory\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Value
 *
 * @Annotation
 * @Annotation\Target("PROPERTY")
 * @package felfactory\Annotation
 */
class Value implements Figure
{
    /**
     * @Annotation\Required()
     * @var string
     */
    public $value;

    public function stringify(): string
    {
        return sprintf("value('%s')", $this->value);
    }

    public function isConfigured(): bool
    {
        return !empty($this->value);
    }
}
