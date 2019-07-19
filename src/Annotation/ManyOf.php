<?php
declare(strict_types=1);

namespace felfactory\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class ManyOf
 *
 * @Annotation
 * @Annotation\Target("PROPERTY")
 * @package felfactory\Annotation
 */
class ManyOf implements Figure
{
    /**
     * @Annotation\Required()
     * @var \felfactory\Annotation\Figure
     */
    public $figure;

    /**
     * @var int
     */
    public $min = 0;

    /**
     * @var int
     */
    public $max = 3;

    public function stringify(): string
    {
        return sprintf('many(%s, %s, %s)', $this->figure->stringify(), $this->min, $this->max);
    }

    public function isConfigured(): bool
    {
        return !empty($this->figure);
    }
}
