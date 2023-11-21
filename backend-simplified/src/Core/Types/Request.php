<?php

namespace Pan93412\StdBackend\Core\Types;

class Request
{
    /**
     * The request method.
     * @var string
     */
    public string $method;

    /**
     * The request path.
     * @var string
     */
    public string $path;

    /**
     * The lowercase header.
     */
    public Header $headers;

    /**
     * The request query.
     * @var array<string, string>
     */
    public array $query;

    /**
     * The request body.
     * @var string|mixed
     */
    public mixed $body;

    public static function fromGlobals(): Request
    {
        $h = new Request();

        $h->method = $_SERVER['REQUEST_METHOD'];
        $h->path = $_SERVER['REQUEST_URI'];
        $h->headers = Header::fromGlobals();
        $h->query = $_GET;
        $h->body = file_get_contents('php://input');

        return $h;
    }

    /**
     * @param string $body
     * @return string|mixed
     */
    private function parseBody(string $body): mixed
    {
        $contentType = $this->headers->get("Content-Type");

        if (str_contains($contentType, "application/json")) {
            return json_decode($body, true);
        }

        return $body;
    }
}

