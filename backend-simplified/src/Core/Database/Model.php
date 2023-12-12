<?php

namespace Pan93412\StdBackend\Core\Database;

abstract class Model
{
    abstract public static function getTable(): string;

    /**
     * @return array<string>
     */
    public static function getColumnNames(): array
    {
        $r = new \ReflectionClass(static::class);
        $cols = [];

        // If users specified `#[FieldName]`, we use it;
        // otherwise, we use the property name.
        foreach ($r->getProperties() as $property) {
            $attrs = $property->getAttributes(FieldName::class);
            if (isset($attrs[0])) {
                $cols[] = $attrs[0]->newInstance()->getName();
            } else {
                $cols[] = $property->getName();
            }
        }

        return $cols;
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
