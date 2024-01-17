<?php

namespace Pan93412\Magical\Types;

class Header
{
    /**
     * @var array<string, string>
     */
    public array $rawHeader;

    public function __construct(?array $header = null)
    {
        $this->rawHeader = $header ?? [];
    }

    public static function fromGlobals(): Header
    {
        return new Header(Header::normalizeHeaderList(getallheaders()));
    }

    /**
     * Normalize the given header to the lowercase key.
     *
     * @param array<string, string> $header
     * @return array<string, string>
     */
    private static function normalizeHeaderList(array $header): array
    {
        return array_change_key_case($header);
    }

    /**
     * Get normalized (a.k.a lowercase) key.
     * @param string $key
     * @return string The normalized key.
     */
    private static function getNormalizedKey(string $key): string
    {
        return strtolower($key);
    }

    /**
     * @param string $key
     * @return string|null
     */
    function get(string $key): ?string
    {
        return $this->rawHeader[Header::getNormalizedKey($key)] ?? null;
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    function set(string $key, string $value): void
    {
        $this->rawHeader[Header::getNormalizedKey($key)] = $value;
    }

    /**
     * @param string $key
     * @return bool
     */
    function isset(string $key): bool
    {
        return isset($this->rawHeader[Header::getNormalizedKey($key)]);
    }

    /**
     * @param string $key
     * @return void
     */
    function unset(string $key): void
    {
        unset($this->rawHeader[Header::getNormalizedKey($key)]);
    }

    /**
     * Get the original headers map.
     *
     * It is immutable to the internal headers map.
     *
     * @return array<string, string>
     */
    function headers(): array {
        return $this->rawHeader;
    }
}
