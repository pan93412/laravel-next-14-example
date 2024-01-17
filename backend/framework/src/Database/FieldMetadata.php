<?php

namespace Pan93412\Magical\Database;

use ReflectionProperty;

readonly class FieldMetadata
{
    /**
     * Construct the field metadata.
     *
     * DON'T CALL THIS UNLESS YOU KNOW WHAT YOU ARE DOING!
     */
    public function __construct(
        private string $propertyName,
        private string $columnName,
        private bool $isImplicit,
        private bool $isPrimary,
        private ReflectionProperty $reflectionProperty
    ){}

    public static function fromReflectionProperty(ReflectionProperty $property): FieldMetadata
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

        return new FieldMetadata($fieldName, $columnName, $isImplicit, $isPrimary, $property);
    }

    public function implicit(): bool
    {
        if ($this->reflectionProperty()->getType()->allowsNull()) {
            return true;
        }

        return $this->isImplicit;
    }

    public function primary(): bool
    {
        return $this->isPrimary;
    }

    public function propertyName(): string
    {
        return $this->propertyName;
    }

    public function columnName(): string
    {
        return $this->columnName;
    }

    public function reflectionProperty(): ReflectionProperty
    {
        return $this->reflectionProperty;
    }

    /**
     * @template T
     * @param array<string, mixed|T> $data
     * @return T|null
     */
    public function pickValue(array $data): mixed
    {
        return $data[$this->columnName()] ?? $data[$this->propertyName()] ?? null;
    }
}
