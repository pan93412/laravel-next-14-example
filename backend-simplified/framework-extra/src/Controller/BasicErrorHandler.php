<?php

namespace Pan93412\MagicalExtra\Controller;

use Pan93412\Magical\Types\Handler;
use Pan93412\Magical\Types\Request;
use Pan93412\Magical\Types\Response;

class BasicErrorHandler implements Handler
{
    public function __invoke(Request $request, Response $response): void
    {
        $response->status(404)->body("No such page: $request->path");
    }
}
