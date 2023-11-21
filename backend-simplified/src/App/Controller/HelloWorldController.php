<?php

namespace Pan93412\StdBackend\App\Controller;

use Pan93412\StdBackend\Core\Types\Handler;
use Pan93412\StdBackend\Core\Types\Request;
use Pan93412\StdBackend\Core\Types\Response;

class HelloWorldController implements Handler
{
    #[\Override] public function handle(Request $request, Response $response): void
    {
        $response->body("Hello, World!");
    }
}
