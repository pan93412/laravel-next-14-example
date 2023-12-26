<?php

namespace Pan93412\StdBackend\App\Controller;

use Pan93412\StdBackend\App\Models\StudentModel;
use Pan93412\StdBackend\Core\Database\Database;
use Pan93412\StdBackend\Core\Exception\MissingField;
use Pan93412\StdBackend\Core\Types\CrudHandler;
use Pan93412\StdBackend\Core\Types\Request;
use Pan93412\StdBackend\Core\Types\Response;
use PDOException;

class StudentController extends CrudHandler
{
    public function __construct(private readonly Database $database)
    {
    }

    /**
     * @throws MissingField
     * @throws PDOException
     */
    public function create(Request $request, Response $response): void
    {
        $form = $request->form();
        $entity = new StudentModel();

        $entity->name = $form["name"] ?? throw new MissingField("name");
        $entity->email = $form["email"] ?? throw new MissingField("email");
        $entity->grade = isset($form["grade"]) ? intval($form["grade"]) : throw new MissingField("grade");
        $entity->birthday = $form["birthday"] ?? throw new MissingField("birthday");

        $this->database->insert($entity);
        $response->status(201);
    }

    public function retrieve(Request $request, Response $response): void
    {
        $response->body(
            $this->database->selectAll(StudentModel::class)
        );
    }

    public function retrieveOne(Request $request, Response $response, string $id): void
    {
        $response->body(
            $this->database->select(StudentModel::class, $id)
        );
    }

    public function update(Request $request, Response $response): void
    {
        $id = $request->form()["id"] ?? throw new MissingField("id");

        $this->database->update(StudentModel::class, $id, $request->form());
        $response->status(204);
    }

    public function delete(Request $request, Response $response): void
    {
        $id = $request->form()["id"] ?? throw new MissingField("id");

        $this->database->delete(StudentModel::class, $id);
    }
}