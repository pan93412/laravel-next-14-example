<?php

namespace Pan93412\StdBackend\Core\Types;

abstract class CrudHandler implements Handler
{
    abstract public function create(Request $request, Response $response): void;
    abstract public function retrieve(Request $request, Response $response): void;
    abstract public function retrieveOne(Request $request, Response $response, string $id): void;
    abstract public function update(Request $request, Response $response): void;
    abstract public function delete(Request $request, Response $response): void;

    public function __invoke(Request $request, Response $response): void
    {
        switch ($request->method) {
            case "GET":
                $id = $request->query["id"] ?? null;

                if ($id != null) {
                    $this->retrieveOne($request, $response, $id);
                } else {
                    $this->retrieve($request, $response);
                }
                break;
            case "POST":
                $this->create($request, $response);
                break;
            case "PUT":
            case "PATCH":
                $this->update($request, $response);
                break;
            case "DELETE":
                $this->delete($request, $response);
                break;
        }
    }
}
