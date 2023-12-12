<?php

namespace Pan93412\StdBackend\App\Controller;

use Pan93412\StdBackend\App\Models\StudentModel;
use Pan93412\StdBackend\Core\Database\Database;
use Pan93412\StdBackend\Core\Types\CrudHandler;
use Pan93412\StdBackend\Core\Types\Request;
use Pan93412\StdBackend\Core\Types\Response;

class StudentController extends CrudHandler
{
    public function __construct(private readonly Database $database)
    {
    }

    public function create(Request $request, Response $response): void
    {
        try {
            $this->database->insert(StudentModel::class, $request->form());
            $response->status(201);
        } catch (\Exception $e) {
            $response->status(500)->setBody([
                "error" => $e->getMessage()
            ]);
        }
    }

    public function retrieve(Request $request, Response $response): void
    {
        $response->setBody(
            $this->database->selectAll(StudentModel::class)
        );
    }

    public function update(Request $request, Response $response): void
    {
        // TODO: Implement update() method.
    }

    public function delete(Request $request, Response $response): void
    {
        // TODO: Implement delete() method.
    }
}