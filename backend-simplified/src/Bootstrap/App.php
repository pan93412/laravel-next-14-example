<?php

namespace Pan93412\Backend\Bootstrap;

use Pan93412\Magical\Database\Database;
use Pan93412\Magical\Types\Request;
use Pan93412\Magical\Types\Response;
use Pan93412\Backend\Routes\WebRouter;
use Throwable;

class App {
    static function run(): void
    {
        // Create the request and response singleton instance
        // since we don't have middleware at this moment.
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
        } catch (Throwable $e) {
            echo "unexpected error: " . $e;
        }
    }
}
