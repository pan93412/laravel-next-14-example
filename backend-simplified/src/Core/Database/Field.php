<?php

namespace Pan93412\StdBackend\Core\Database;

class Field
{
    public function __construct(
        public string $propertyName,
        public string $columnName,
        public bool $isImplicit,
        public bool $isPrimary,
    ){}

    public static function fromReflectionProperty(\ReflectionProperty $property): Field
    {
        $attributes = $property->getAttributes();
        $fieldName = $property->getName();
        $columnName = $fieldName;
        $isImplicit = false;
        $isPrimary = false;

        foreach ($attributes as $attribute) {
            if ($attribute->getName() === ColumnName::class) {
                $columnName = $attribute->newInstance()->getName();
            } elseif ($attribute->getName() === ImplicitValue::class) {
                $isImplicit = true;
            } elseif ($attribute->getName() === PrimaryKey::class) {
                $isPrimary = true;
            }
        }

        return new Field($fieldName, $columnName, $isImplicit, $isPrimary);
    }
}
