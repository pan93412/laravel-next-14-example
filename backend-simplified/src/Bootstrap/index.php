<?php

namespace Pan93412\StdBackend\Bootstrap;

// Create the request and response singleton instance
// since we don't have middleware at this moment.

use Pan93412\StdBackend\Core\Types\Request;
use Pan93412\StdBackend\Core\Types\Response;
use Pan93412\StdBackend\Routes\WebRouter;

$request = Request::fromGlobals();
$response = new Response();

$router = new WebRouter();
$router->request($request, $response);
