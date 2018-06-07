<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 25-03-18
 * Time: 12:53
 */

namespace Framework\Database\QueryBuilder;


class Insert extends QueryBuilder
{
    protected $properties = [
        'columns' => null,
        'table' => null
    ];

    /**
     * @param string $table
     * @return $this
     */
    public function from($table)
    {
        $this->properties['table'] = $table;
        return $this;
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function columns(array $columns)
    {
        $this->properties['columns'] = $columns;
        return $this;
    }

    /**
     * @return string
     */
    public function build()
    {
        $sql = ["INSERT INTO"];
        $sql[] = "`{$this->properties['table']}`";

        if (isset($this->properties['columns']))
            $sql[] = "(" . implode(",", $this->apply_backTicks($this->properties['columns'])) . ")";

        $sql[] = "VALUES";

        $sql[] = "(" . implode(',', array_map(function ($val) {
                return " :$val ";
            }, array_values($this->properties['columns']))) . ")";

        return implode(" ", $sql);
    }
}