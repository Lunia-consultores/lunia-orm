<?php

namespace LuniaConsultores\LuniaOrm;

use Illuminate\Support\Facades\DB;
use ReflectionClass;

class EntityRepository
{
    protected TransformObject $transformObject;
    protected EntityDefinition $entityDefinition;

    public function __construct(TransformObject $transformObject)
    {
        $this->transformObject = $transformObject;
    }

    /**
     * @throws \ReflectionException
     */
    public function find($identifier): ?object
    {
        $entity = DB::table($this->entityDefinition->tableName)->where($this->entityDefinition->keyColumnName, '=', $identifier)->first();

        return $entity !== null ? $this->transformObject->transformar($entity, $this->entityDefinition->className, $this->entityDefinition->map, $this->entityDefinition->cast) : null;
    }

    /**
     * @throws \ReflectionException
     */
    public function persistir($eventoAdministrado): void
    {
        $eventoAdministradoExistente = $this->find($eventoAdministrado->id());

        $params = [];
        $entidad = clone $eventoAdministrado;
        $reflection = new ReflectionClass($entidad);

        foreach ($this->entityDefinition->map as $column => $property) {
            $property = $reflection->getProperty($property);
            $property->setAccessible(true);
            $params[$column] = $property->getValue($entidad);
        }

        if ($eventoAdministradoExistente) {
            DB::table($this->entityDefinition->tableName)->where($this->entityDefinition->keyColumnName, '=', $this->entityDefinition->getIdentifier($eventoAdministrado))->update($params);
        } else {
            DB::table($this->entityDefinition->tableName)->insert($params);
        }
    }
}