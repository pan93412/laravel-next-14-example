<?php

namespace Pan93412\StdBackend\App\Models;

use Pan93412\StdBackend\Core\Database\ColumnName;
use Pan93412\StdBackend\Core\Database\Model;

class SupplierModel extends Model
{
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
