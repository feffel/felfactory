<?php
declare(strict_types=1);

namespace felfactory\Models;

use felfactory\Statement\Statement;
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

    /** @var Statement */
    public $statement;

    /** @var ?callable */
    public $callback;

    /** @var bool|null */
    public $primitive;

    /** @var bool|null */
    protected $array;

    public function isArray(): bool
    {
        // @TODO ADD getters and setters and handle this better
        if ($this->array !== null) {
            return $this->array;
        }
        $this->array = substr_compare($this->type, '[]', -2) === 0;
        if ($this->array) {
            $this->type = substr($this->type, 0, -2);
        }

        return $this->array;
    }
}
