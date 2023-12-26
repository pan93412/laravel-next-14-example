<?php

namespace Pan93412\StdBackend\Core\Router;

use Exception;
use Pan93412\StdBackend\Core\Converter\JsonConverter;
use Pan93412\StdBackend\Core\Converter\Converter;
use Pan93412\StdBackend\Core\Types\Handler;
use Pan93412\StdBackend\Core\Types\Request;
use Pan93412\StdBackend\Core\Types\Response;
use ReflectionClass;

class Router
{
    /**
     * @var array<string, array<Handler>>
     */
    protected array $handlers;

    /**
     * @var array<string, class-string<Converter>>
     */
    protected array $converters = [
        JsonConverter::class,
    ];

    /**
     * @var array<class-string, object>
     */
    protected array $diContainer = [];

    public function __construct()
    {
    }

    function addInjectable(object $value): void
    {
        $r = new \ReflectionObject($value);
        $n = $r->getName();
        $this->diContainer[$n] = $value;
    }

    /**
     * @param string $method The method to catch. "*" Means all methods.
     * @param string $path The path to catch. "*" Means all paths.
     * @param class-string<Handler> $handler
     * @return void
     * @throws Exception
     */
    function register(string $method, string $path, string $handler): void
    {
        $this->handlers[$method][$path] = $this->createInjectedInstance($handler);
    }

    /**
     * @template T
     * @param class-string<T> $c
     * @return T
     * @throws Exception
     */
    protected function createInjectedInstance(string $c): object
    {
        $reflection = new ReflectionClass($c);
        $constructor = $reflection->getConstructor();
        if ($constructor === null) {
            return $reflection->newInstance();
        }

        $params = $constructor->getParameters();

        $args = [];
        foreach ($params as $param) {
            $type = $param->getType();
            if ($type === null) {
                throw new Exception("Cannot resolve type of parameter {$param->getName()} in {$c}");
            }

            $type = $type->getName();
            if (!isset($this->diContainer[$type])) {
                throw new Exception("Cannot resolve type {$type} in {$c}");
            }

            $args[] = $this->diContainer[$type];
        }

        return $reflection->newInstanceArgs($args);
    }

    function request(Request $request, Response $response): void
    {
        $method = $request->method;
        $path = $request->path;

        $handler = $this->handlers[$method][$path]
            ?? $this->handlers["*"][$path]
            ?? $this->handlers["*"]["*"];

        try {
            $handler($request, $response);

            // Render the response.
            $this->render($response);
        } catch (\Throwable $e) {
            // fixme: customizable error handler
            $resp = new Response();
            $resp->status(is_numeric($e->getCode()) ? intval($e->getCode()) : 500);
            $resp->body([
                "error" => $e::class,
                "message" => $e->getMessage(),
                "file" => $e->getFile() . ":" . $e->getLine(),
            ]);
            $this->render($resp);
        }
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

        header("HTTP/1.1 {$response->getStatus()}");
        foreach ($response->getHeaders() as $key => $value) {
            header("$key: $value");
        }

        $body = $response->getBody();
        if (!$body) {
            return;
        }
        echo $body;
    }
}
