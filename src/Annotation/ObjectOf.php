<?php
declare(strict_types=1);

namespace felfactory\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class ObjectOf
 *
 * @Annotation
 * @Annotation\Target("PROPERTY")
 * @package felfactory\Annotation
 */
class ObjectOf implements Figure
{
    /**
     * @Annotation\Required()
     * @var string
     */
    public $class;

    public function stringify(): string
    {
        return sprintf('class(%s)', $this->class);
    }

    public function isConfigured(): bool
    {
        return !empty($this->class);
    }
}
