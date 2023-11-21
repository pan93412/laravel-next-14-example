<?php

namespace Pan93412\StdBackend\Core\Types;

class Response
{
    private mixed $body;
    private int $status;
    private Header $headers;

    public function __construct()
    {
        $this->body = null;
        $this->status = 200;
        $this->headers = new Header();
    }

    public function getBody(): mixed
    {
        return $this->body;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getHeaders(): Header
    {
        return $this->headers;
    }

    public function setBody(mixed $body): void
    {
        $this->body = $body;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @param Header $headers
     * @return void
     */
    public function setHeaders(Header $headers): void
    {
        $this->headers = $headers;
    }

    /* region: fluent */
    /**
     * @param mixed $body
     * @return Response
     */
    public function body(mixed $body): Response {
        $this->body = $body;
        return $this;
    }

    /**
     * @param int $status
     * @return Response
     */
    public function status(int $status): Response
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param Header $headers
     * @return Response
     */
    public function headers(Header $headers): Response
    {
        $this->headers = $headers;
        return $this;
    }
}
