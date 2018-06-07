<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 24-03-18
 * Time: 12:44
 */

namespace Framework\Model\Entity;


class EntityProperty
{
    private $dirty;
    private $name;
    private $value;

    /**
     * EntityProperty constructor.
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
        $this->dirty = false;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * @return string
     */
    public function toBind()
    {
        return ":$this->name";
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function set($value)
    {
        $this->value = $value;
        $this->dirty = true;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function isDirty()
    {
        return $this->dirty;
    }
}