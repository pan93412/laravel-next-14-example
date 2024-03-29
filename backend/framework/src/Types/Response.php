<?php

namespace Pan93412\Magical\Types;

class Response
{
    private mixed $body;
    private ?int $status;
    private Header $headers;

    public function __construct()
    {
        $this->body = null;
        $this->status = null;
        $this->headers = new Header();
    }

    public function getBody(): mixed
    {
        return $this->body;
    }

    public function getStatus(): int
    {
        return $this->status ?? (
            is_null($this->body) ? 204 : 200
        );
    }

    public function getHeader(string $key): ?string
    {
        return $this->headers->get($key);
    }

    /**
     * @returns array<string, string>
     */
    public function getHeaders(): array
    {
        return $this->headers->headers();
    }

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
        if ($status < 100 || $status > 599) {
            $this->status = 500;
        }
        return $this;
    }

    /**
     * Set one-line header.
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function header(string $key, string $value): Response
    {
        $this->headers->set($key, $value);
        return $this;
    }
}
