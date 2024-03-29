<?php

namespace Pan93412\MagicalExtra\Handlers;

use Exception;
use Pan93412\Magical\Database\Database;
use Pan93412\Magical\Database\Model;
use Pan93412\Magical\Exception\MissingField;
use Pan93412\Magical\Types\CrudHandler;
use Pan93412\Magical\Types\Request;
use Pan93412\Magical\Types\Response;

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
     * @throws Exception
     */
    public function create(Request $request, Response $response): void
    {
        $form = $request->form();

        $entity = static::newModel();
        $columnsMeta = $entity::getColumnsMeta();

        foreach ($columnsMeta as $meta) {
            $value = $meta->pickValue($form);

            // if this column is implicit, we allow skipping it
            if (is_null($value)) {
                if ($meta->implicit()) continue;
                throw new Exception("Missing field: {$meta->columnName()}", 400);
            }

            $meta->reflectionProperty()->setValue($entity, $value);
        }

        $id = $this->database->insert($entity);

        $response->status(201)
                 ->body(["id" => $id]);
    }

    public function retrieve(Request $request, Response $response): void
    {
        $model = static::newModel()::class;
        $response->body($this->database->selectAll($model));
    }

    /**
     * @throws Exception
     */
    public function retrieveOne(Request $request, Response $response, string $id): void
    {
        $model = static::newModel()::class;
        $response->body($this->database->select($model, $id));
    }

    /**
     * @throws Exception
     */
    public function update(Request $request, Response $response): void
    {
        $model = static::newModel();
        $idField = $model::getPrimaryKey()->columnName();

        $id = $request->form()[$idField] ?? throw new MissingField($idField);
        $set = [];

        foreach ($model::getColumnsMeta() as $meta) {
            $value = $meta->pickValue($request->form());
            if (is_null($value)) continue;

            $set[$meta->columnName()] = $value;
        }

        if (count($set) === 0) {
            throw new Exception("No field to update", 400);
        }

        $this->database->update($model::class, $id, $set);
        $response->status(204);
    }

    /**
     * @throws Exception
     */
    public function delete(Request $request, Response $response): void
    {
        $model = static::newModel();
        $idField = $model::getPrimaryKey()->columnName();

        $id = $request->form()[$idField] ?? throw new MissingField($idField);

        $this->database->delete($model::class, $id);
        $response->status(204);
    }
}