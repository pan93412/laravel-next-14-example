<?php

namespace Pan93412\Backend\App\Models;

use Pan93412\Magical\Database\ColumnName;
use Pan93412\Magical\Database\ImplicitValue;
use Pan93412\Magical\Database\Model;
use Pan93412\Magical\Database\PrimaryKey;

class EmployeeModel extends Model
{
    #[PrimaryKey]
    #[ImplicitValue]
    public int $id;
    public string $name;
    public string $password;
    #[ColumnName("join_at")]
    #[ImplicitValue]
    public string $joinAt;
    public ?string $address;
    public ?string $email;
    public ?string $phone;

    public static function getTable(): string
    {
        return "employees";
    }
}
