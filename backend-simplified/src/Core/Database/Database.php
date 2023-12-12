<?php

namespace Pan93412\StdBackend\Core\Database;

use InvalidArgumentException;
use PDO;
use PDOStatement;

final class Database
{
    private ?PDO $connection = null;

    public function __construct(
        private readonly string $host,
        private readonly string $username,
        private readonly string $password,
        private readonly string $database,
        private readonly int    $port = 3306,
        private readonly string $charset = "utf8mb4",
    )
    {
        $this->connect();
    }

    public function connect(): void
    {
        $this->connection = new PDO(
            "mysql:host={$this->host};port={$this->port};dbname={$this->database};charset={$this->charset}",
            $this->username,
            $this->password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false,
            ]
        );
    }

    protected function getConnection(): PDO
    {
        if ($this->connection === null) {
            $this->connect();
        }

        return $this->connection;
    }

    /**
     * @template T of Model
     * @param class-string<T> $model
     * @return array<T>
     */
    public function selectAll(string $model): array
    {
        $tableName = $model::getTable();

        $statement = $this->connection->prepare("SELECT * FROM {$tableName}");
        $statement->execute();

        $resultRows = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $resultRows[] = $model::fromMap($row);
        }

        return $resultRows;
    }

    /**
     * @param Model $entity
     * @return void
     * @throws InvalidArgumentException
     */
    public function insert(mixed $entity): void
    {
        $tableName = $entity::getTable();
        $columns = $entity::getColumnNames();
        $values = $entity->getValues($columns);

        $statement = $this->connection->prepare(
            "INSERT INTO {$tableName} (" . implode(", ", $columns) . ") VALUES (" . implode(", ", array_fill(0, count($columns), "?")) . ")"
        );
        $statement->execute(array_values($values));
    }
}
