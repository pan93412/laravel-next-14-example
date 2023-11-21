<?php

namespace Pan93412\StdBackend\Core\Router;

use Pan93412\StdBackend\Core\Controller\DefaultErrorHandler;
use Pan93412\StdBackend\Core\Types\Handler;
use Pan93412\StdBackend\Core\Types\Request;
use Pan93412\StdBackend\Core\Types\Response;

class Router
{
    /**
     * @var array<string, array<Handler>>
     */
    protected array $handlers;

    protected Handler $globalErrorHandler;

    public function __construct(?Handler $globalErrorHandler = null)
    {
        $this->globalErrorHandler = $globalErrorHandler ?? new DefaultErrorHandler();
    }

    function register(string $method, string $path, $handler): void
    {
        $this->handlers[$method][$path] = $handler;
    }

    function request(Request $request, Response $response)
    {
        $method = $request->method;
        $path = $request->path;

        $handler = $this->handlers[$method][$path] ?? $this->globalErrorHandler;
        $handler->handle($request, $response);

        // Render the response.
        $this->render($response);
    }

    protected function render(Response $response): void
    {
        http_response_code($response->getStatus());
        echo $response->getBody();
    }
}
