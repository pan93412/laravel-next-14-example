<?php

namespace Pan93412\StdBackend\Core\Exception;

use Throwable;

class MissingField extends \InvalidArgumentException
{
    public function __construct(public string $fieldName = "", ?Throwable $previous = null)
    {
        parent::__construct("missing field: {$this->fieldName}", 400, $previous);
    }
}
