<?php

namespace felfactory\Annotation;

interface Figure
{
    public function stringify(): string;

    public function isConfigured(): bool;
}
