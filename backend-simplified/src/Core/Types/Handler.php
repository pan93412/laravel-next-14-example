<?php

namespace Pan93412\StdBackend\Core\Types;

interface Handler
{
    public function __invoke(Request $request, Response $response): void;
}
