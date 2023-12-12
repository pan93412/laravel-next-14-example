<?php

namespace Pan93412\StdBackend\Core\Types;

use JsonException;
use Pan93412\StdBackend\Core\Exception\NotAJson;

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
     * @return array<string, string | array<string>>
     */
    public function form(): array
    {
        $contentType = $this->headers->get("Content-Type");
        $result = [];

        if (str_contains($contentType, "application/x-www-form-urlencoded")) {
            parse_str($this->body, $result);
        }

        return $result;
    }

    /**
     * @return mixed
     * @throws JsonException
     * @throws NotAJson
     */
    public function json(): mixed
    {
        $contentType = $this->headers->get("Content-Type");

        if (str_contains($contentType, "application/json")) {
            return json_decode($this->body, true, flags: JSON_THROW_ON_ERROR);
        }

        throw new NotAJson();
    }
}

