<?php

namespace Pan93412\Magical\Database;

use Exception;
use InvalidArgumentException;
use PDO;
use PDOException;

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
            "mysql:host=$this->host;port=$this->port;dbname=$this->database;charset=$this->charset",
            $this->username,
            $this->password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => true,
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

        $statement = $this->getConnection()->prepare("SELECT * FROM $tableName");
        $statement->execute();

        $resultRows = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $resultRows[] = $model::fromMap($row);
        }

        return $resultRows;
    }

    /**
     * @template T of Model
     * @param class-string<T> $model
     * @param string $id
     * @return ?T
     * @throws Exception
     */
    public function select(string $model, string $id): mixed
    {
        $tableName = $model::getTable();
        $idField = $model::getPrimaryKey()->columnName();

        $statement = $this->getConnection()->prepare("SELECT * FROM $tableName WHERE $idField = ?");
        $statement->execute([$id]);

        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row !== false) {
            return $model::fromMap($row);
        }

        return null;
    }

    /**
     * @template T of Model
     * @param class-string<T> $model
     * @param string $id
     * @param array<string, mixed> $set
     * @return void
     * @throws Exception
     */
    public function update(string $model, string $id, array $set): void
    {
        $tableName = $model::getTable();
        $idField = $model::getPrimaryKey()->columnName();

        $statement = $this->getConnection()->prepare(
            "UPDATE $tableName SET". implode(", ", array_map(fn($column) => " $column = :$column", array_keys($set))) . " WHERE $idField = :$idField"
        );
        $statement->execute(array_merge($set, [$idField => $id]));
    }

    /**
     * @template T of Model
     * @param class-string<T> $model
     * @param string $id
     * @return void
     * @throws Exception
     */
    public function delete(string $model, string $id): void
    {
        $tableName = $model::getTable();
        $idField = $model::getPrimaryKey()->columnName();

        $statement = $this->getConnection()->prepare("DELETE FROM $tableName WHERE $idField = ?");
        $statement->execute([$id]);
    }

    /**
     * @param Model $entity
     * @return string The inserted ID.
     * @throws InvalidArgumentException
     * @throws PDOException
     */
    public function insert(mixed $entity): string
    {
        $tableName = $entity::getTable();
        $idField = $entity::getPrimaryKey()->columnName();

        // column name -> entity value
        /** @var array<string, string> $columnValueMap */
        $columnValueMap = [];

        foreach ($entity::getColumnsMeta() as $column) {
            if (!$column->reflectionProperty()->isInitialized($entity)) {
                if ($column->implicit()) continue;
                throw new InvalidArgumentException("Property {$column->propertyName()} is not initialized.");
            }

            $columnValueMap[$column->columnName()] = $column->reflectionProperty()->getValue($entity);
        }
        $statement = $this->getConnection()->prepare(
            "INSERT INTO $tableName (" . implode(", ", array_keys($columnValueMap)) . ") VALUES (" . implode(", ", array_fill(0, count($columnValueMap), "?")) . ")"
        );
        $statement->execute(array_values($columnValueMap));

        return $this->getConnection()->lastInsertId();
    }
}
