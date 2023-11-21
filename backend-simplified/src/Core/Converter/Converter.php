<?php

namespace Pan93412\StdBackend\Core\Converter;

use Pan93412\StdBackend\Core\Types\Response;

/**
 * @template T
 */
interface Converter
{
    /**
     * Convert the data as a string that can presents to users.
     *
     * Write your converted value directly to the response object.
     * If the given data is not supported, return false, and we will
     * find another converter to handle it.
     *
     * @param Response $response
     * @returns bool
     */
    public function convert(Response $response): bool;
}
