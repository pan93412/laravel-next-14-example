<?php

namespace Pan93412\Magical\Database;

use Attribute;

/**
 * Declare that this value has a default value.
 *
 * Note that a nullable value implicits the ImplicitValue.
 */
#[Attribute]
readonly class ImplicitValue
{
    public function __construct()
    {
    }
}
