<?php

namespace Pan93412\StdBackend\Routes;

use Pan93412\StdBackend\App\Controller\HelloWorldController;
use Pan93412\StdBackend\App\Controller\InfoController;
use Pan93412\StdBackend\Core\Router\Router;

class WebRouter extends Router {
    function __construct()
    {
        parent::__construct();
        $this->register("GET", "/", new HelloWorldController());
        $this->register("GET", "/info", new InfoController());
    }
}
