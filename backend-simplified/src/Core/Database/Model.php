<?php

namespace Pan93412\StdBackend\Core\Database;

use Exception;
use ReflectionClass;
use ReflectionProperty;

abstract class Model
{
    abstract public static function getTable(): string;

    /**
     * Get the {@see FieldMetadata} metadata of this model.
     *
     * @return array<string, FieldMetadata> The key is the property name; the value is the Field object.
     */
    public static function getColumnsMeta(): array
    {
        $r = new ReflectionClass(static::class);
        $cols = [];

        foreach ($r->getProperties() as $property) {
            $field = FieldMetadata::fromReflectionProperty($property);
            $cols[$field->propertyName()] = $field;
        }

        return $cols;
    }

    /**
     * @throws Exception
     */
    public static function getPrimaryKey(): FieldMetadata {
        $columns = static::getColumnsMeta();
        foreach ($columns as $column) {
            if ($column->primary()) {
                return $column;
            }
        }
        throw new Exception("No primary key found.");
    }

    /**
     * Turn the `FETCH_ASSOC` array into a model.
     *
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromMap(array $data): self
    {
        $model = new static();

        // Create a map of column name => reflection_property
        /** @var array<string, ReflectionProperty> $fields */
        $fields = [];
        foreach (static::getColumnsMeta() as $field) {
            $fields[$field->columnName()] = $field->reflectionProperty();
        }

        foreach ($data as $key => $value) {
            $field = $fields[$key] ?? null;
            if ($field === null) {
                error_log("Column $key not found in model " . static::class);
                continue;
            }

            $field->setValue($model, $value);
        }

        return $model;
    }
}
