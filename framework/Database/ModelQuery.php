<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 19-03-18
 * Time: 13:43
 */

namespace Framework\Database;

use Exception;
use Framework\Database\QueryBuilder\Condition;
use Framework\Database\QueryBuilder\QueryBuilder;
use Framework\Model\Entity;
use Framework\Model\Entity\EntityPatcher;
use framework\Model\Table;
use PDO;
use PDOStatement;

class ModelQuery
{
    /**
     * @var Table $table
     * @var bool $hasFailed
     **/
    private
        $table;

    /**
     * QueryBuilder constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * @param $value
     * @param null $keyName
     * @return bool
     * @throws Exception
     */
    public function exists($value, $keyName = null)
    {
        $key = isset($keyName) ? $keyName : $this->table->getPrimaryKey();

        $result = $this->toEntity(DatabaseConnection::query(QueryBuilder::select()->columns()->from($this->table->getTableName())->where(Condition::make($key)), [$value]));

        return !empty($result);
    }

    /**
     * @param $value
     * @param null $keyName
     * @return Entity
     * @throws Exception
     */
    public function get($value, $keyName = null)
    {
        $key = isset($keyName) ? $keyName : $this->table->getPrimaryKey();

        $result = $this->toEntity(
            DatabaseConnection::query(
                QueryBuilder::select()
                    ->columns()
                    ->from($this->table->getTableName())
                    ->where(Condition::make($key))
                ,
                [$value]
            )
        );

        return empty($result) ? $result : $result[0];
    }

    /**
     * @param $rawSQL
     * @param array $params
     * @return Entity[]
     * @throws Exception
     */
    public function query($rawSQL, array $params = [])
    {
        return $this->toEntity(
            DatabaseConnection::query($rawSQL, $params)
        );
    }

    /**
     * @param QueryBuilder $continue
     * @param $params
     * @return Entity[]
     * @throws Exception
     */
    public function select(QueryBuilder $continue = null, array $params = [])
    {
        if (is_null($continue)) $continue = QueryBuilder::select();

        return $this->toEntity(
            DatabaseConnection::query(
                QueryBuilder::select()
                    ->from($this->table->getTableName())->merge($continue)
                ,
                $params
            )
        );
    }

    /**
     * @param QueryBuilder $otherPart
     * @param array $params
     */
    public function update(QueryBuilder $otherPart, array $params = [])
    {
        DatabaseConnection::query(
            QueryBuilder::update()
                ->from($this->table->getTableName())->merge($otherPart)
            ,
            $params
        );
    }

    /**
     * @param QueryBuilder $otherPart
     * @param array $params
     * @throws Exception
     */
    public function insert(QueryBuilder $otherPart, array $params = [])
    {
        DatabaseConnection::query(
            QueryBuilder::insert()
                ->from($this->table->getTableName())->merge($otherPart)
            ,
            $params
        );
    }

    /**
     * @param QueryBuilder $otherPart
     * @param array $params
     */
    public function delete(QueryBuilder $otherPart, array $params = [])
    {
        DatabaseConnection::query(
            QueryBuilder::delete()
                ->from($this->table->getTableName())->merge($otherPart)
            ,
            $params
        );
    }

    /**
     * @param PDOStatement $statement
     * @return Entity[]
     * @throws Exception
     */
    private function toEntity(PDOStatement $statement)
    {
        $patcher = new EntityPatcher($this->table);

        while ($element = $statement->fetch(PDO::FETCH_ASSOC)) {
            $patcher->patch($element);
        }

        //clear the memory
        $statement->closeCursor();

        return $patcher->toArray();
    }
}