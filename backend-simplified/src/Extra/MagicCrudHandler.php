<?php

namespace Pan93412\StdBackend\Extra;

use Pan93412\StdBackend\App\Models\StudentModel;
use Pan93412\StdBackend\Core\Database\Database;
use Pan93412\StdBackend\Core\Database\Model;
use Pan93412\StdBackend\Core\Exception\MissingField;
use Pan93412\StdBackend\Core\Types\CrudHandler;
use Pan93412\StdBackend\Core\Types\Request;
use Pan93412\StdBackend\Core\Types\Response;

abstract class MagicCrudHandler extends CrudHandler
{
    /**
     * @return Model
     */
    protected abstract function newModel(): Model;

    public function __construct(private readonly Database $database)
    {
    }

    /**
     * @throws \ReflectionException
     */
    public function create(Request $request, Response $response): void
    {
        $form = $request->form();

        $entity = static::newModel();
        $columnNames = $entity::getColumnNames();

        $entityReflection = new \ReflectionObject($entity);

        foreach ($columnNames as $columnName) {
            // if this column
            $value = $form[$columnName] ?? null;

            // if this column is nullable, we allow skipping it
            if (is_null($value) && $entityReflection->getProperty($columnName)->getType()->allowsNull()) {
                continue;
            }

            $entity->$columnName = $value;
        }

        $this->database->insert($entity);
        $response->status(201);
    }

    public function retrieve(Request $request, Response $response): void
    {
        $model = static::newModel()::class;
        $response->body($this->database->selectAll($model));
    }

    public function retrieveOne(Request $request, Response $response, string $id): void
    {
        $model = static::newModel()::class;
        $response->body($this->database->select($model, $id));
    }

    /**
     * @throws \Exception
     */
    public function update(Request $request, Response $response): void
    {
        $model = static::newModel();
        $idField = $model::getIdField();

        $id = $request->form()[$idField] ?? throw new MissingField($idField);
        $set = [];

        foreach ($model::getColumnNames() as $columnName) {
            $value = $request->form()[$columnName] ?? null;
            if (is_null($value)) continue;

            $set[$columnName] = $value;
        }

        if (count($set) === 0) {
            throw new \Exception("No field to update", 400);
        }

        $this->database->update($model::class, $id, $set);
        $response->status(204);
    }

    public function delete(Request $request, Response $response): void
    {
        $model = static::newModel();
        $idField = $model::getIdField();

        $id = $request->form()[$idField] ?? throw new MissingField($idField);

        $this->database->delete($model::class, $id);
        $response->status(204);
    }
}