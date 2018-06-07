<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 24-03-18
 * Time: 12:11
 */

namespace Framework\Model\Table;


class TableRegistry
{
    private static $tables = [];

    /**
     * @param $name
     * @return mixed
     */
    public static function get($name)
    {
        if (array_key_exists($name,self::$tables))
            return self::$tables[$name];

        $namespace = "Framework\Model\Table\\{$name}Table";
        return $tables[$name] = new $namespace();
    }
}