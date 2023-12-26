<?php

namespace Pan93412\StdBackend\Core\Database;

use Attribute;

/**
 * Declare that this value is a primary key.
 *
 * It is usually the `id` column. If you do not
 * declare PrimaryKey, `id` is.
 */
#[Attribute]
readonly class PrimaryKey
{
    public function __construct()
    {
    }
}
