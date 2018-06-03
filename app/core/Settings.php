<?php

namespace app\core;

/**
 * Class Settings
 *
 * @property-read bool $isDebug
 * @property-read string $dbDsn
 * @property-read int $pageSize
 * @property-read string $viewPath
 */
final class Settings
{
    /**
     * @var array
     */
    private $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @throws \BadMethodCallException
     *
     * @return mixed|null
     */
    public function __call($name, $arguments)
    {
        if (strpos($name, 'has') === 0) {
            return $this->hasValue(lcfirst(substr($name, 3)));
        }

        if (strpos($name, 'get') === 0) {
            return $this->get(lcfirst(substr($name, 3)));
        }

        throw new \BadMethodCallException("Method $name is not exists");
    }

    /**
     * @param string $name
     *
     * @throws \BadMethodCallException
     *
     * @return mixed|null
     */
    public function __get(string $name)
    {
        if ($this->hasValue($name)) {
            return $this->get($name);
        }

        throw new \InvalidArgumentException("Attribute $name is not exists");
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return mixed|null
     */
    public function __set(string $name, $value)
    {
        throw new \InvalidArgumentException("Attribute $name is read only");
    }

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function __isset(string $name)
    {
        return $this->hasValue($name);
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function get(string $name)
    {
        return $this->settings[$name] ?? null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasValue(string $name): bool
    {
        return \array_key_exists($name, $this->settings);
    }
}
