<?php

namespace LuniaConsultores\LuniaOrm;

use DateTime;
use Exception;
use Ramsey\Uuid\Uuid;
use ReflectionObject;
use stdClass;

class TransformObject
{
    /**
     * @throws Exception
     * @return mixed
     */
    private function cast($value, $type)
    {
        if ($value === null) {
            return null;
        }

        switch ($type) {
            case 'uuid':
                return Uuid::fromString($value);
            case 'int':
                return (int) $value;
            case 'string':
                return (string) $value;
            case 'bool':
                return (bool) $value;
            case 'datetime':
                return (new DateTime($value));
            default:
                return new $type($value);
        }
    }

    /**
     * @return mixed
     * @throws \ReflectionException
     */
    public function transformar(stdClass $dbObject, string $className, array $map, array $cast)
    {
        $prototype = unserialize(sprintf('O:%d:"%s":0:{}', strlen($className), $className));
        $entity = clone $prototype;
        $reflection = new ReflectionObject($entity);

        foreach ($map as $column => $property) {
            $property = $reflection->getProperty($property);
            $property->setAccessible(true);
            $property->setValue($entity, $this->cast($dbObject->$column, $cast[$property->getName()]));
        }

        return $entity;
    }
}
