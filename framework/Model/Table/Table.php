<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 20-03-18
 * Time: 21:22
 */

namespace Framework\Model;


use Exception;
use Framework\Functions;


abstract class Table
{
    protected $keys = [];
    /* @var array $columns */
    protected $columns = [];
    protected $linkedTables = [];
    protected $name;

    /**
     * @return array
     */
    public function getLinkedTables()
    {
        return $this->linkedTables;
    }

    /**
     * @param string $tableName
     */
    protected function hasMany($tableName)
    {
        $this->linkedTables[] = ['has_many', $tableName];
    }

    /*
     *
     */
    protected function hasOne($tableName)
    {
        $this->linkedTables[] = ['has_one', $tableName];
    }

    /**
     * Table constructor.
     */
    public function __construct()
    {
        $this->name = $this->getTableNameFromClass();
        $this->initialize();
    }

    /**
     * @param $key
     * @internal param array $keys
     */
    public function setKey($key)
    {
        $this->keys[] = $key;
    }

    /**
     * @return bool|string
     */
    private function getTableNameFromClass()
    {
        $className = Functions::getClassName($this);
        return substr($className,0,strpos($className,"Table"));
    }

    /**
     * @return mixed
     */
    public abstract function initialize();

    /**
     * @param $name
     * @return Column
     */
    protected function declareColumn($name)
    {
        return $this->columns[$name] = new Column($name,$this);
    }

    /**
     * @return null
     * @throws Exception
     */
    public function getPrimaryKey()
    {
        foreach ($this->keys as $column)
        {
            $column = $this->getColumn($column);
            if($column->isPrimaryKey())
                return $column->getName();
        }

        throw new Exception("Table $this->name has no primary key");
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * @return bool|string
     */
    public function getTableName()
    {
        return strtolower($this->name);
    }

    /**
     * @param string $name
     * @return Column
     */
    public function getColumn($name)
    {
        return array_key_exists($name, $this->columns)
            ? $this->columns[$name]
            : null;
    }
}