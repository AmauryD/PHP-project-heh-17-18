<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 20-03-18
 * Time: 21:32
 */

namespace Framework\Model;


use PDO;

class Column
{
    private $name;
    private $dataType;
    /* @var Table $parent */
    private $parent;
    private $isKey = false;
    private $isPrimary = false;
    private $isNull = false;
    private $lenght;

    /**
     * Column constructor.
     * @param string $name
     * @param Table $parent
     */
    public function __construct($name,&$parent)
    {
        $this->name = $name;
        $this->parent = $parent;          //link to parent class for updates
        $this->dataType = PDO::PARAM_STR; //STR by default
    }

    /**
     * @return bool
     */
    public function isKey()
    {
        return $this->isKey;
    }

    /**
     * @return bool
     */
    public function isPrimaryKey()
    {
        return $this->isPrimary;
    }

    /**
     * @return bool
     */
    public function isNull()
    {
        return $this->isNull;
    }

    /**
     * @param mixed $lenght
     * @return Column
     */
    public function setLenght($lenght)
    {
        $this->lenght = $lenght;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLenght()
    {
        return $this->lenght;
    }

    /**
     * @return mixed
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @param int $dataType
     * @return $this
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $isNull
     * @return $this
     */
    public function setIsNull($isNull)
    {
        $this->isNull = $isNull;
        return $this;
    }

    /**
     * @param $isKey
     * @return $this
     */
    public function setIsKey($isKey)
    {
        $this->isKey = $isKey;
        $this->setIsNull(false);
        $this->parent->setKey($this->name);
        return $this;
    }

    /**
     * @param bool $isPrimary
     * @return $this
     */
    public function setIsPrimary($isPrimary)
    {
        $this->isPrimary = $isPrimary;
        $this->setIsKey(true);
        return $this;
    }
}