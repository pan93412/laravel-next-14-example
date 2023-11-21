<?php

namespace Pan93412\StdBackend\App\Controller;

use Pan93412\StdBackend\Core\Types\Handler;
use Pan93412\StdBackend\Core\Types\Request;
use Pan93412\StdBackend\Core\Types\Response;

class InfoController implements Handler
{
    #[\Override] public function handle(Request $request, Response $response): void
    {
        $response->body([
            "method" => $request->method,
            "path" => $request->path,
            "query" => $request->query,
            "body" => $request->body,
            "headers" => $request->headers,
        ]);
    }
}
