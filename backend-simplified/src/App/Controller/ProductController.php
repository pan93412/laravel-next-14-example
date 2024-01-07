<?php

namespace Pan93412\StdBackend\App\Controller;

use Pan93412\StdBackend\App\Models\ProductModel;
use Pan93412\StdBackend\Core\Database\Model;
use Pan93412\StdBackend\Extra\MagicCrudHandler;

class ProductController extends MagicCrudHandler
{
    /**
     * @inheritDoc
     */
    protected function newModel(): Model
    {
        return new ProductModel();
    }
}