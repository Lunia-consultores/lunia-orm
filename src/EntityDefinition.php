<?php

namespace LuniaConsultores\LuniaOrm;

abstract class EntityDefinition
{
    public string $className;
    public string $tableName;
    public string $keyColumnName = 'id';
    public array $map;
    public array $cast;

    abstract public function getIdentifier($entity);
}
