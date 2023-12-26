<?php

namespace Pan93412\StdBackend\Core\Database;

use ReflectionProperty;

abstract class Model
{
    abstract public static function getTable(): string;
    public static function getIdField(): string {
        return "id";
    }

    /**
     * @return array<string, Field> The key is the property name; the value is the Field object.
     */
    public static function getColumnsMeta(): array
    {
        $r = new \ReflectionClass(static::class);
        $cols = [];

        foreach ($r->getProperties() as $property) {
            $field = Field::fromReflectionProperty($property);
            $cols[$field->propertyName] = $field;
        }

        return $cols;
    }

    /**
     * @deprecated
     * @return array<string, ReflectionProperty>
     */
    public static function getColumns(): array
    {
        $r = new \ReflectionClass(static::class);
        $cols = [];

        // If users specified `#[FieldName]`, we use it;
        // otherwise, we use the property name.
        foreach ($r->getProperties() as $property) {
            $attrs = $property->getAttributes(ColumnName::class);
            $key = $property->getName();
            if (isset($attrs[0])) {
                $key = $attrs[0]->newInstance()->getName();
            }

            $cols[$key] = $property;
        }

        return $cols;
    }

    public static function fromMap(array $data): self
    {
        $model = new static();

        $columns = static::getColumns();
        foreach ($data as $key => $value) {
            if (isset($columns[$key])) {
                $columns[$key]->setValue($model, $value);
            }
        }

        return $model;
    }

    /**
     * @return array<string>
     */
    public static function getColumnNames(): array
    {
        return array_keys(static::getColumns());
    }

    /**
     * @param array<string> $columns
     * @return array
     */
    public function getValues(array $columns): array {
        $values = [];
        foreach ($columns as $column) {
            $values[] = $this->{$column};
        }
        return $values;
    }
}
