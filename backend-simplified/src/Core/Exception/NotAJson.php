<?php

namespace Pan93412\StdBackend\Core\Exception;

use Throwable;

class NotAJson extends \InvalidArgumentException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct("not a JSON", 400, $previous);
    }
}