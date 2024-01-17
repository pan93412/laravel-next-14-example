<?php

namespace Pan93412\Magical\Database;

use Attribute;

/**
 * Specify the column name of the property.
 *
 * Sometimes, the column name of the property is different
 * from the column name of the database, for example, the
 * property `userName` is `user_name` in the database.
 *
 * You can mark `userName` with `#[ColumnName("user_name")]`
 * to explicitly specify the column name of the property.
 * If you don't specify the column name, the column name
 * will be the same as the property name.
 */
#[Attribute]
readonly class ColumnName
{
    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
