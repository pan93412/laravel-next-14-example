<?php

namespace Pan93412\Backend\App\Models;

use Pan93412\Magical\Database\ImplicitValue;
use Pan93412\Magical\Database\Model;
use Pan93412\Magical\Database\PrimaryKey;

class ProductModel extends Model
{
    #[PrimaryKey]
    #[ImplicitValue]
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
