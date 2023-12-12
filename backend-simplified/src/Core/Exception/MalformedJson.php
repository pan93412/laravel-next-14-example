<?php

namespace Pan93412\StdBackend\Core\Exception;

use Exception;

class NotAJson extends Exception
{
    public function __construct()
    {
        parent::__construct("Not a JSON.", 400);
    }
}