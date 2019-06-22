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
    private $name;

    /** @var ?string */
    private $type;

    /** @var ReflectionProperty */
    private $ref;

    /** @var Statement */
    private $statement;

    /** @var callable */
    private $callback;

    /** @var bool|null */
    private $primitive;

    /** @var bool|null */
    private $array;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->array = substr_compare($type, '[]', -2) === 0;
        if ($this->array) {
            $type = substr($type, 0, -2);
        }
        $this->type = $type;
    }

    public function getRef(): ReflectionProperty
    {
        return $this->ref;
    }

    public function getStatement(): Statement
    {
        return $this->statement;
    }

    public function hasStatement(): bool
    {
        return $this->statement !== null;
    }

    public function setStatement(Statement $statement): void
    {
        $this->statement = $statement;
    }

    public function getCallback(): callable
    {
        return $this->callback;
    }

    public function setCallback(callable $callback): void
    {
        $this->callback = $callback;
    }

    public function isPrimitive(): ?bool
    {
        return $this->primitive;
    }

    public function setPrimitive(?bool $primitive): void
    {
        $this->primitive = $primitive;
    }

    public function isArray(): bool
    {
        return $this->array ?? false;
    }

    public function isConfigured(): bool
    {
        return $this->statement !== null;
    }
}
