<?php

namespace Pan93412\StdBackend\Core\Router;

use Pan93412\StdBackend\Core\Types\Handler;

/**
 * The pattern tree.
 *
 * The tree is like:
 *
 * - GET - / - path1 - * - . (handler)
 */
class PatternTree
{
    /**
     * The pattern tree.
     *
     * @var array<string, array|Handler>
     */
    private array $patterns;

    public function __construct()
    {
        $this->patterns = [];
    }

    /**
     * Add a pattern to the tree.
     *
     * @param string $method
     * @param string $pattern The pattern to add.
     * @param Handler $handler The handler to add.
     * @return void
     * @throws \Exception
     */
    public function add(string $method, string $pattern, Handler $handler): void
    {
        $parts = explode("/", $pattern);
        array_unshift($parts, strtoupper($method));
        $current = &$this->patterns;

        foreach ($parts as $part) {
            // root
            if ($part === "") continue;

            if ($part === "*?") {
                $current["."] = $handler;
            }

            if (!isset($current[$part])) {
                $current[$part] = [];
            }

            // *? = `/r` or `r/*`
            // fixme: readability
            if ($part === "*?") {
                $current[$part]["."] = $handler;
            }

            $current = &$current[$part];
        }

        $current["."] = $handler;
    }

    /**
     * Find a pattern in the tree.
     *
     * @param string $method
     * @param string $pattern The pattern to find.
     * @return ?Handler
     */
    public function find(string $method, string $pattern): ?Handler
    {
        // Clean up the query string.
        $pattern = explode("?", $pattern)[0];
        
        $mergedPatternTree = array_merge($this->patterns["*"] ?? [], $this->patterns[$method] ?? []);
        $current = &$mergedPatternTree;
        $parts = explode("/", $pattern);

        foreach ($parts as $part) {
            // root
            if ($part === "") continue;

            if (!isset($current[$part])) {
                $subtree = $current["*"] ?? $current["*?"] ?? null;
                if ($subtree === null) {
                    return null;
                }
                $current = &$subtree;
            }

            $current = &$current[$part];
        }

        return $current["."] ?? null;
    }
}
