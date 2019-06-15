<?php
declare(strict_types=1);

namespace felfactory\Models;

use ReflectionProperty;

class Property
{
    public function __construct(ReflectionProperty $refProperty, ?string $type = null, ?bool $primitive = false)
    {
        $this->name      = $refProperty->getName();
        $this->ref       = $refProperty;
        $this->type      = $type;
        $this->primitive = $primitive;
    }

    /** @var string */
    public $name;

    /** @var ?string */
    public $type;

    /** @var ReflectionProperty */
    public $ref;

    /** @var ?callable */
    public $callback;

    /** @var bool|null */
    public $primitive;
}
