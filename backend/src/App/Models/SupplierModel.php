<?php

namespace Pan93412\Backend\App\Models;

use Pan93412\Magical\Database\ImplicitValue;
use Pan93412\Magical\Database\Model;
use Pan93412\Magical\Database\PrimaryKey;

class SupplierModel extends Model
{
    #[PrimaryKey]
    #[ImplicitValue]
    public int $id;
    public string $name;
    public ?string $contact;
    public string $phone;
    public string $address; /* unique */

    public static function getTable(): string
    {
        return "suppliers";
    }
}
