<?php

namespace Pan93412\Backend\App\Models;

use Pan93412\Magical\Database\Model;

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
