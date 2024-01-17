<?php

namespace Pan93412\Magical\Converter;

use Pan93412\Magical\Types\Response;

class JsonConverter implements Converter
{
    /**
     * @inheritDoc
     */
    public function convert(Response $response): bool
    {
        // If the response is a primitive type (string, number, boolean, null),
        // and the content type is not set, we must not touch it.
        if (is_scalar($response->getBody()) &&
            $response->getHeader("Content-Type") !== "application/json") {
            return false;
        }

        if (is_null($response->getBody())) {
            return true; /* leave it as 'null' */
        }

        $encodedResult = json_encode($response->getBody());
        if ($encodedResult === false) {
            return false;
        }

        $response->header(key: "Content-Type", value: "application/json")
            ->body($encodedResult);
        return true;
    }
}
