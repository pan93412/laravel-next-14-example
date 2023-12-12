<?php

namespace Pan93412\StdBackend\Core\Router;

use Pan93412\StdBackend\Core\Controller\DefaultErrorHandler;
use Pan93412\StdBackend\Core\Converter\JsonConverter;
use Pan93412\StdBackend\Core\Converter\Converter;
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

    /**
     * @var array<string, Converter>
     */
    protected array $converters = [
        JsonConverter::class,
    ];

    public function __construct(?Handler $globalErrorHandler = null)
    {
        $this->globalErrorHandler = $globalErrorHandler ?? new DefaultErrorHandler();
    }

    function register(string $method, string $path, Handler $handler): void
    {
        $this->handlers[$method][$path] = $handler;
    }

    function request(Request $request, Response $response): void
    {
        $method = $request->method;
        $path = $request->path;

        $handler = $this->handlers[$method][$path] ?? $this->globalErrorHandler;
        $handler($request, $response);

        // Render the response.
        $this->render($response);
    }

    protected function render(Response $response): void
    {
        foreach ($this->converters as $converterClass) {
            // Get converter.
            $converter = new $converterClass();
            $succeed = $converter->convert($response);

            if ($succeed) {
                break;
            }
        }

        // Write to html.
        header("HTTP/1.1 {$response->getStatus()}");
        foreach ($response->getHeaders()->headers() as $key => $value) {
            header("$key: $value");
        }
        echo $response->getBody();
    }
}
