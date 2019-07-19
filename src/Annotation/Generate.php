<?php
declare(strict_types=1);

namespace felfactory\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Generate
 *
 * @Annotation
 * @Annotation\Target("PROPERTY")
 * @package felfactory\Annotation
 */
class Generate implements Figure
{
    /**
     * @Annotation\Required()
     * @var string
     */
    public $generator;

    public function stringify(): string
    {
        return sprintf("generate('%s')", $this->generator);
    }

    public function isConfigured(): bool
    {
        return !empty($this->generator);
    }
}
