<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 25-03-18
 * Time: 12:52
 */

namespace Framework\Database\QueryBuilder;

/*
 * only Create, Read, Update, Delete queries
 */

abstract class QueryBuilder
{
    const TYPE_NOTSET = 0;
    const TYPE_SELECT = 1;
    const TYPE_INSERT = 2;
    const TYPE_DELETE = 3;
    const TYPE_UPDATE = 4;

    protected $sql_type;
    protected $binded = [];
    protected $properties = [];

    /**
     * QueryBuilder constructor.
     */
    public function __construct()
    {
        $this->sql_type = self::TYPE_NOTSET;
    }

    public static function select()
    {
        return new Select();
    }

    public static function delete()
    {
        return new Delete();
    }

    public static function insert()
    {
        return new Insert();
    }

    public static function update()
    {
        return new Update();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->build();
    }

    /**
     * @param QueryBuilder $other
     * @return $this
     */
    public function merge(QueryBuilder $other)
    {
        foreach ($this->properties as $property => $value) {
            if (!is_null($other->properties[$property]))
                $this->properties[$property] = $other->properties[$property];
        }
        return $this;
    }

    /**
     * @return string
     */
    public abstract function build();

    /**
     * @param array $arr
     * @return array
     */
    protected function apply_backTicks(array $arr)
    {
        return array_map(function ($x) {
            return "`$x`";
        }, $arr);
    }
}