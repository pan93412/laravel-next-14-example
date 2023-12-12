<?php

namespace Pan93412\StdBackend\App\Models;

use Pan93412\StdBackend\Core\Database\Model;

class StudentModel extends Model
{
    public string $name;
    public string $email;
    public int $grade;
    public string $birthday;
    public ?int $id = null;

    public static function getTable(): string
    {
        return "students";
    }
}
