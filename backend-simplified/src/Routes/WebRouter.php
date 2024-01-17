<?php

namespace Pan93412\Backend\Routes;

use Exception;
use Pan93412\Backend\App\Controller\EmployeeController;
use Pan93412\Backend\App\Controller\HelloWorldController;
use Pan93412\Backend\App\Controller\InfoController;
use Pan93412\Backend\App\Controller\ProductController;
use Pan93412\Backend\App\Controller\RoleController;
use Pan93412\Backend\App\Controller\StudentController;
use Pan93412\Backend\App\Controller\SupplierController;
use Pan93412\Magical\Database\Database;
use Pan93412\Magical\Router\Router;
use Pan93412\MagicalExtra\Controller\BasicNotFoundHandler;

class WebRouter extends Router {
    /**
     * @throws Exception
     */
    function __construct(Database $database)
    {
        parent::__construct();
        $this->addInjectable($database);
        $this->register("*", "*", BasicNotFoundHandler::class);
        $this->register("GET", "/", HelloWorldController::class);
        $this->register("GET", "/info", InfoController::class);
        $this->register("*", "/students/*?", StudentController::class);
        $this->register("*", "/employees/*?", EmployeeController::class);
        $this->register("*", "/products/*?", ProductController::class);
        $this->register("*", "/roles/*?", RoleController::class);
        $this->register("*", "/suppliers/*?", SupplierController::class);
    }
}
