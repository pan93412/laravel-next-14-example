<?php

namespace Pan93412\StdBackend\Routes;

use Exception;
use Pan93412\StdBackend\App\Controller\EmployeeController;
use Pan93412\StdBackend\App\Controller\HelloWorldController;
use Pan93412\StdBackend\App\Controller\InfoController;
use Pan93412\StdBackend\App\Controller\ProductController;
use Pan93412\StdBackend\App\Controller\RoleController;
use Pan93412\StdBackend\App\Controller\StudentController;
use Pan93412\StdBackend\App\Controller\SupplierController;
use Pan93412\StdBackend\Core\Controller\DefaultErrorHandler;
use Pan93412\StdBackend\Core\Database\Database;
use Pan93412\StdBackend\Core\Router\Router;

class WebRouter extends Router {
    /**
     * @throws Exception
     */
    function __construct(Database $database)
    {
        parent::__construct();
        $this->addInjectable($database);
        $this->register("*", "*", DefaultErrorHandler::class);
        $this->register("GET", "/", HelloWorldController::class);
        $this->register("GET", "/info", InfoController::class);
        $this->register("*", "/students/*?", StudentController::class);
        $this->register("*", "/employees/*?", EmployeeController::class);
        $this->register("*", "/products/*?", ProductController::class);
        $this->register("*", "/roles/*?", RoleController::class);
        $this->register("*", "/suppliers/*?", SupplierController::class);
    }
}
