<?php

namespace Pan93412\StdBackend\App\Models;

use Pan93412\StdBackend\Core\Database\ColumnName;
use Pan93412\StdBackend\Core\Database\Model;

class RoleModel extends Model
{
    public int $id;
    public string $name;

    public static function getTable(): string
    {
        return "roles";
    }
}
