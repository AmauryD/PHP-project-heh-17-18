<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 25-03-18
 * Time: 14:14
 */

namespace Framework\Database\QueryBuilder;


class Condition
{
    protected $parts;

    /**
     * Condition constructor.
     * @param $key
     * @param string $operator
     * @param string $bindName
     */
    public function __construct($key, $operator = '=', $bindName = '?')
    {
        $this->parts[] = [null, $key, $operator, $bindName];
        return $this;
    }

    /**
     * @param $key
     * @param string $operator
     * @param string $bindName
     * @return Condition
     */
    public static function make($key, $operator = '=', $bindName = '?')
    {
        return new Condition($key, $operator, $bindName);
    }

    /**
     * @param $key
     * @param string $operator
     * @param string $bindName
     * @return $this
     */
    public function orGroup($key, $operator = '=', $bindName = '?')
    {
        $this->parts[] = ['OR', $key, $operator, $bindName];
        return $this;
    }

    /**
     * @param $key
     * @param string $operator
     * @param string $bindName
     * @return $this
     */
    public function andGroup($key, $operator = '=', $bindName = '?')
    {
        $this->parts[] = ['AND', $key, $operator, $bindName];
        return $this;
    }

    public function params()
    {
        $params = [];

        foreach ($this->parts as list($grp, $key, $operator, $bindName))
            $params[] = ":$bindName";

        return $params;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $sql = [];

        foreach ($this->parts as list($grp, $key, $operator, $bindName)) {
            if (empty($sql))
                if ($bindName === '?')
                    $sql[] = "$key $operator $bindName";
                else
                    $sql[] = "$key $operator :$bindName";
            else
                if ($bindName === '?')
                    $sql[] = "$key $operator $bindName";
                else
                    $sql[] = "$grp $key $operator :$bindName";
        }

        return implode(' ', $sql);
    }
}