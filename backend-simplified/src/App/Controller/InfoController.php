<?php

namespace Pan93412\Backend\App\Controller;

use Override;
use Pan93412\Magical\Types\Handler;
use Pan93412\Magical\Types\Request;
use Pan93412\Magical\Types\Response;

class InfoController implements Handler
{
    #[Override] public function __invoke(Request $request, Response $response): void
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
