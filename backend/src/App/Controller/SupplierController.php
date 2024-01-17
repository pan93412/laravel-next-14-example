<?php

namespace Pan93412\Backend\App\Controller;

use Pan93412\Backend\App\Models\SupplierModel;
use Pan93412\Magical\Database\Model;
use Pan93412\MagicalExtra\Handlers\MagicCrudHandler;

class SupplierController extends MagicCrudHandler
{
    /**
     * @inheritDoc
     */
    protected function newModel(): Model
    {
        return new SupplierModel();
    }
}