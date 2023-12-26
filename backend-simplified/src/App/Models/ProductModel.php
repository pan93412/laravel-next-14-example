<?php

namespace Pan93412\StdBackend\App\Models;

use Pan93412\StdBackend\Core\Database\FieldName;
use Pan93412\StdBackend\Core\Database\Model;

class ProductModel extends Model
{
    public int $id;
    public string $name;
    public float $cost;
    public float $price;
    public int $qty;

    public static function getTable(): string
    {
        return "products";
    }
}
