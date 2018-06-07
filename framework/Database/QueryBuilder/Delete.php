<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 25-03-18
 * Time: 12:53
 */

namespace Framework\Database\QueryBuilder;


/*
 * DELETE FROM table_name WHERE condition;
 */

class Delete extends QueryBuilder
{
    protected $properties = [
        'table' => null,
        'condition' => null
    ];

    public function __construct()
    {
        parent::__construct();
        $this->sql_type = QueryBuilder::TYPE_DELETE;
    }

    public function from($table)
    {
        $this->properties['table'] = $table;
        return $this;
    }

    public function where(Condition $condition)
    {
        $this->properties['condition'] = $condition;
        return $this;
    }

    /**
     * @return string
     */
    public function build()
    {
        $sql = ["DELETE FROM"];

        if (isset($this->properties['table'])) {
            $sql[] = $this->properties['table'];
        }

        $sql[] = "WHERE";

        if (isset($this->properties['condition'])) {
            $sql[] = (string)$this->properties['condition'];
        }

        return implode(" ", $sql);
    }
}