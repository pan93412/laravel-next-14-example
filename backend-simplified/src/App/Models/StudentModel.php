<?php

namespace Pan93412\StdBackend\App\Models;

use Pan93412\StdBackend\Core\Database\Model;

class StudentModel extends Model
{
    public function __construct(
        public string $name,
        public string $email,
        public string $grade,
        public string $birthday,
        public ?int $id,
    ) {}

    public static function getTable(): string
    {
        return "students";
    }
}
