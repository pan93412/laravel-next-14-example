<?php

namespace Pan93412\Magical\Database;

use Attribute;

/**
 * Declare that this value is a primary key.
 *
 * It is usually the `id` column.
 */
#[Attribute]
readonly class PrimaryKey
{
    public function __construct()
    {
    }
}
