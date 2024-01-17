<?php

namespace Pan93412\Backend\App\Models;

use Pan93412\Magical\Database\ImplicitValue;
use Pan93412\Magical\Database\Model;
use Pan93412\Magical\Database\PrimaryKey;

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
