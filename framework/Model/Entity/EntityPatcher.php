<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 11-05-18
 * Time: 12:44
 */

namespace Framework\Model\Entity;


use framework\Exception\FatalErrorException;
use Framework\Model\Entity;
use Framework\Model\Table;

class EntityPatcher
{
    private $entities = [];
    private $table;
    private $uniqueKey;

    public function __construct(Table &$table, $uniqueKey = null)
    {
        $this->table = $table;
        $this->uniqueKey = $uniqueKey;
    }

    /**
     * @param $element
     * @throws FatalErrorException
     */
    public function patch($element)
    {
        $tableName = $this->table->getTableName();
        $tableKeys = $this->table->getKeys();

        if (!isset($this->uniqueKey)) {
            foreach (array_keys($element) as $key) {
                if (strpos($key, ".") !== false) {
                    $table = explode(".", $key)[0];
                    if ($table == $tableName)
                        $this->uniqueKey = $key;
                } else {
                    if (in_array($key, $tableKeys))
                        $this->uniqueKey = $key;
                }
            }
            if (!isset($this->uniqueKey)) {
                throw new FatalErrorException("No valid unique key found in request");
            }
        }

        if (array_key_exists($element[$this->uniqueKey], $this->entities)) {
            $this->entities[$element[$this->uniqueKey]]->patch($element);
        } else {
            $entity = Entity::create($tableName, false);
            $this->entities[$element[$this->uniqueKey]] = $entity;
            $entity->patch($element, $this->uniqueKey);
        }
    }

    public function toArray()
    {
        return array_values($this->entities);
    }
}