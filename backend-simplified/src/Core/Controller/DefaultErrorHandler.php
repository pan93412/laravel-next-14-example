<?php

namespace Pan93412\StdBackend\Core\Controller;

use Pan93412\StdBackend\Core\Types\Handler;
use Pan93412\StdBackend\Core\Types\Request;
use Pan93412\StdBackend\Core\Types\Response;

class DefaultErrorHandler implements Handler
{
    public function __invoke(Request $request, Response $response): void
    {
        $response->status(404)->body("No such page: {$request->path}");
    }
}
