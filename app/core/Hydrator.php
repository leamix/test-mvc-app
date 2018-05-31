<?php

namespace app\core;

final class Hydrator
{
    /**
     * @var array
     */
    private $reflectionsCache = [];

    /**
     * @param array $data
     * @param string $className
     * @return object
     */
    public function hydrate(array $data, string $className)
    {
        $reflection = $this->getReflectionClass($className);
        $object = $reflection->newInstanceWithoutConstructor();

        return $this->hydrateObject($data, $object);
    }

    /**
     * @param array $data
     * @param object $object
     * @return object
     */
    public function hydrateObject(array $data, $object)
    {
        $className = \get_class($object);
        $reflection = $this->getReflectionClass($className);

        foreach ($data as $key => $value) {
            if ($reflection->hasProperty($value)) {
                $property = $reflection->getProperty($value);
                $property->setAccessible(true);
                $property->setValue($object, $data[$key]);
            }
        }

        return $object;
    }

    /**
     * @param object $object
     * @return array
     */
    public function extract($object): array
    {
        $data = [];

        $className = \get_class($object);
        $reflection = $this->getReflectionClass($className);
        $properties = $reflection->getProperties();

        foreach ($properties as $value) {
            $property = $reflection->getProperty($value);
            $property->setAccessible(true);
            $data[$property->getName()] = $property->getValue($object);
        }

        return $data;
    }

    /**
     * @param string $className
     * @return \ReflectionClass
     * @throws \ReflectionException
     */
    private function getReflectionClass($className): \ReflectionClass
    {
        if (!isset($this->reflectionsCache[$className])) {
            $this->reflectionsCache[$className] = new \ReflectionClass($className);
        }
        return $this->reflectionsCache[$className];
    }
}
