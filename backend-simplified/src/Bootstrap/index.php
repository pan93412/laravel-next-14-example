<?php

namespace Pan93412\StdBackend\Bootstrap;

// Create the request and response singleton instance
// since we don't have middleware at this moment.

use Pan93412\StdBackend\Core\Database\Database;
use Pan93412\StdBackend\Core\Types\Request;
use Pan93412\StdBackend\Core\Types\Response;
use Pan93412\StdBackend\Routes\WebRouter;

$request = Request::fromGlobals();
$response = new Response();

$database = new Database(
    "db",
    "db",
    "db",
    "db",
);

try {
    $router = new WebRouter($database);
    $router->request($request, $response);
} catch (\Throwable $e) {
    echo "unexpected error: " . $e;
}
