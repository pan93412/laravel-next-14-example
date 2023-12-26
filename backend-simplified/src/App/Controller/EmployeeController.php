<?php

namespace Pan93412\StdBackend\App\Controller;

use Pan93412\StdBackend\App\Models\EmployeeModel;
use Pan93412\StdBackend\Core\Database\Model;
use Pan93412\StdBackend\Extra\MagicCrudHandler;

class EmployeeController extends MagicCrudHandler
{
    /**
     * @inheritDoc
     */
    protected function newModel(): Model
    {
        return new EmployeeModel();
    }
}