<?php

namespace Pan93412\Backend\App\Controller;

use Pan93412\Backend\App\Models\StudentModel;
use Pan93412\Magical\Database\Model;
use Pan93412\MagicalExtra\Handlers\MagicCrudHandler;

class StudentController extends MagicCrudHandler
{
    /**
     * @inheritDoc
     */
    protected function newModel(): Model
    {
        return new StudentModel();
    }
}