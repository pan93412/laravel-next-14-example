<?php

namespace Pan93412\Magical\Types;

interface Handler
{
    public function __invoke(Request $request, Response $response): void;
}
