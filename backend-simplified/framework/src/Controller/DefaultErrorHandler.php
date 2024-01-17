<?php

namespace Pan93412\Magical\Controller;

use Pan93412\Magical\Types\Handler;
use Pan93412\Magical\Types\Request;
use Pan93412\Magical\Types\Response;

class DefaultErrorHandler implements Handler
{
    public function __invoke(Request $request, Response $response): void
    {
        $response->status(404)->body("No such page: $request->path");
    }
}
