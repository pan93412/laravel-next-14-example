<?php

namespace Pan93412\StdBackend\Core\Database;

use Attribute;

#[Attribute]
class FieldName
{
    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
