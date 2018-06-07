<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 06-04-18
 * Time: 14:48
 */

namespace Framework\Database\QueryBuilder;


class Update extends QueryBuilder
{

    protected $properties = [
        'columns' => null,
        'table' => null,
        'conditions' => null
    ];

    /**
     * Select constructor.
     * @param int $type
     */
    public function __construct($type = Select::SELECT_CLASSIC)
    {
        parent::__construct();
        $this->sql_type = QueryBuilder::TYPE_UPDATE;
    }

    public function from($table)
    {
        $this->properties['table'] = $table;
        return $this;
    }

    public function columns(array $values)
    {
        $this->properties['columns'] = $values;
        return $this;
    }

    /**
     * @param Condition $whereStatement
     * @return $this
     */
    public function where(Condition $whereStatement)
    {
        $this->properties['conditions'] = $whereStatement;
        return $this;
    }


    /**
     * @return string
     */
    public function build()
    {
        $sql = ["UPDATE"];

        $sql[] = "`{$this->properties['table']}`";
        $sql[] = "SET";


        $columns = [];

        foreach ($this->properties['columns'] as $column) {
            $columns[] = "$column = :$column";
        };

        $sql[] = implode(",", $columns);

        if (isset($this->properties['conditions'])) {
            $sql[] = "WHERE"; //add WHERE to the query
            $sql[] = (string)$this->properties['conditions'];
        }

        return implode(' ', $sql);
    }
}