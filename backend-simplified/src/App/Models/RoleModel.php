<?php

namespace Pan93412\StdBackend\App\Models;

use Pan93412\StdBackend\Core\Database\ColumnName;
use Pan93412\StdBackend\Core\Database\ImplicitValue;
use Pan93412\StdBackend\Core\Database\Model;
use Pan93412\StdBackend\Core\Database\PrimaryKey;

class RoleModel extends Model
{
    #[PrimaryKey]
    #[ImplicitValue]
    public int $id;
    public string $name;

    public static function getTable(): string
    {
        return "roles";
    }
}
