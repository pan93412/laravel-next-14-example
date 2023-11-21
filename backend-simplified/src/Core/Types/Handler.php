<?php

namespace Pan93412\StdBackend\Core\Types;

interface Handler
{
    public function handle(Request $request, Response $response): void;
}
