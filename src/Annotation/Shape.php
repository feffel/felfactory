<?php
declare(strict_types=1);

namespace felfactory\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Property
 *
 * @Annotation
 * @Annotation\Target("PROPERTY")
 *
 * @package felfactory\Annotation
 */
class Shape
{
    /**
     * @Annotation\Required()
     * @var string
     */
    public $shape;
}
