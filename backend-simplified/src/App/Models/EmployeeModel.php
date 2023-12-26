<?php

namespace Pan93412\StdBackend\App\Models;

use Pan93412\StdBackend\Core\Database\ColumnName;
use Pan93412\StdBackend\Core\Database\ImplicitValue;
use Pan93412\StdBackend\Core\Database\Model;
use Pan93412\StdBackend\Core\Database\PrimaryKey;

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
