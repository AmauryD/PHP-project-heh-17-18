<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 25-03-18
 * Time: 12:53
 */

namespace Framework\Database\QueryBuilder;

/*
    'longest' sql select statement
    $select_type $columns FROM $tables $joinStatement
    WHERE $conditions GROUPBY $column HAVING $havingStatement ORDERBY $column
    LIMIT $limit
*/

class Select extends QueryBuilder
{
    // sql fields
    const SELECT_DISTINCT = 0;

    // type
    const SELECT_CLASSIC = 1;

    // merge-able properties
    protected $properties = [
        'table' => null,
        'columns' => [],
        'joins' => null,
        'conditions' => null,
        'groupBy' => null,
        'having' => null,
        'orderBy' => null,
        'limit' => null
    ];

    private
        $select_type;

    /**
     * Select constructor.
     * @param int $type
     */
    public function __construct($type = Select::SELECT_CLASSIC)
    {
        parent::__construct();
        $this->sql_type = QueryBuilder::TYPE_SELECT;
        $this->select_type = $type;
        $this->properties['columns'] = ['*'];
        $this->properties['joins'] = [];
    }

    /**
     * @param string $table
     * @return $this
     */
    public function from($table)
    {
        $this->properties['table'] = strtolower($table);
        return $this;
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function columns(array $columns = ['*'])
    {
        $this->properties['columns'] = $columns;
        return $this;
    }


    /**
     * @param string $table
     * @param string $key
     * @param string $foreignKey
     * @param string $type
     * @return $this
     * @internal param array $joinArray
     */
    public function join($table, $key, $foreignKey, $type = 'INNER')
    {
        $this->properties['joins'][] = [$table, $key, $foreignKey, $type];
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
     * @param string $column
     * @return $this
     */
    public function group($column)
    {
        $this->properties['groupBy'] = $column;
        return $this;
    }

    /**
     * @param Condition $condition
     * @return $this
     */
    public function having(Condition $condition)
    {
        $this->properties['having'] = $condition;
        return $this;
    }

    /**
     * @param $column
     * @param string $order
     * @return $this
     */
    public function orderBy($column, $order = 'DESC')
    {
        $this->properties['orderBy'] = [$column, $order];
        return $this;
    }

    /**
     * @param $number
     * @return $this
     */
    public function limit($number)
    {
        $this->properties['limit'] = $number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function table()
    {
        return $this->properties['table'];
    }

    /**
     * @return string
     */
    public function build()
    {
        $sql = [];

        $sql[] = ($this->select_type == self::SELECT_CLASSIC) ? "SELECT" : "SELECT DISTINCT";

        if (isset($this->properties['columns'])) {
            if ($this->properties['columns'] == ['*']) {
                $sql[] = '*';
            } else {

                $cols = array_map(function ($x) {
                    if (strpos($x, '.') !== false)
                        return "$x AS '$x'";
                    return "$x AS '{$this->properties['table']}.$x'";
                }, $this->properties['columns']);

                $sql[] = implode(',',
                    $cols
                );
            }
        }

        $sql[] = "FROM"; //add from select to the query

        if (isset($this->properties['table'])) {
            $sql[] = "`{$this->properties['table']}`";
        }

        if (isset($this->properties['joins'])) {
            foreach ($this->properties['joins'] as list($table, $key, $foreignKey, $type)) {
                if ($type === 'NATURAL') {
                    $sql[] = "$type JOIN `$table`";
                    continue;
                }
                $sql[] = "$type JOIN `$table` ON $key=$foreignKey";
            }
        }

        if (isset($this->properties['conditions'])) {
            $sql[] = "WHERE"; //add WHERE to the query
            $sql[] = (string)$this->properties['conditions'];
        }

        if (isset($this->properties['groupBy'])) {
            $sql[] = "GROUP BY";
            $sql[] = "`{$this->properties['groupBy']}`";
        }

        if (isset($this->properties['having'])) {
            $sql[] = "HAVING";
            $sql[] = $this->properties['having'];
        }

        if (isset($this->properties['orderBy'])) {
            $sql[] = "ORDER BY";
            $sql[] = "`{$this->properties['orderBy'][0]}`";
            $sql[] = $this->properties['orderBy'][1];
        }

        if (isset($this->properties['limit'])) {
            $sql[] = "LIMIT " . $this->properties['limit'];
        }

        return implode(" ", $sql);
    }
}