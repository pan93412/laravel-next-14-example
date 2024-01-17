<?php

namespace Pan93412\Backend\App\Controller;

use Override;
use Pan93412\Magical\Types\Handler;
use Pan93412\Magical\Types\Request;
use Pan93412\Magical\Types\Response;

class HelloWorldController implements Handler
{
    #[Override] public function __invoke(Request $request, Response $response): void
    {
        $response->body("Hello, World!");
    }
}
