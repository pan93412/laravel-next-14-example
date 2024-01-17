<?php

namespace Pan93412\Backend\App\Models;

use Pan93412\Magical\Database\ImplicitValue;
use Pan93412\Magical\Database\Model;
use Pan93412\Magical\Database\PrimaryKey;

class StudentModel extends Model
{
    #[PrimaryKey]
    #[ImplicitValue]
    public int $id;

    public string $name;
    public string $email;
    public int $grade;
    public string $birthday;

    public static function getTable(): string
    {
        return "students";
    }
}
