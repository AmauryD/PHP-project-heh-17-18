<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 18-03-18
 * Time: 12:44
 */

namespace Framework\Model;

use Exception;
use Framework\Database\ModelQuery;
use Framework\Database\QueryBuilder\Condition;
use Framework\Database\QueryBuilder\QueryBuilder;
use framework\Exception\FatalErrorException;
use Framework\Functions;
use Framework\Model\Entity\EntityProperty;
use Framework\Model\Table\TableRegistry;

abstract class Entity
{
    /* @var Table $table */
    protected $table;
    /* @var array $properties */
    protected $properties;
    protected $isNew;

    private $model;

    /**
     * Entity constructor.
     * @param array $properties
     * @param bool $isNew
     */
    public function __construct(array $properties = [], $isNew = true)
    {
        $className = Functions::getClassName($this);
        $this->table = TableRegistry::get($className.'s'); // table name is plural of the entity class name
        $this->isNew = $isNew;
        $this->model = new ModelQuery($this->table);

        foreach ($this->table->getLinkedTables() as list($type, $linkedTableName)) {
            if ($type === 'has_many')
                $this->{strtolower($linkedTableName)} = [];
            if ($type === 'has_one')
                $this->{$linkedTableName} = null;
        }

        $this->set($properties);
    }

    /**
     * @param EntityProperty $property
     * @return mixed
     */
    protected abstract function onPropertySet(EntityProperty &$property);

    /**
     * @param EntityProperty $property
     * @return mixed
     */
    protected function onPropertyGet(EntityProperty &$property)
    {
        return $property->value();
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->isNew;
    }

    /**
     * @return array
     */
    public function properties()
    {
        return $this->properties;
    }

    public function propertiesNames()
    {
        return array_keys($this->properties);
    }

    public function propertiesValues()
    {
        return array_map(function ($a) {
            return $a->value();
        }, $this->properties);
    }

    public function dirtyPropertiesNames()
    {
        $toReturn = [];
        foreach ($this->properties as $property) {
            if ($property->isDirty()) $toReturn[] = $property->getName();
        }

        return $toReturn;
    }

    public function dirtyPropertiesValues()
    {
        $toReturn = [];
        foreach ($this->properties as $property) {
            if ($property->isDirty()) $toReturn[$property->getName()] = $property->value();
        }

        return $toReturn;
    }

    public function propertiesToAssoc()
    {
        $array = [];

        foreach ($this->properties as $property)
            $array[$property->getName()] = $property->value();

        return $array;
    }

    /**
     * @param $propertyName
     * @return mixed
     */
    public function get($propertyName)
    {
        if (isset($this->properties[$propertyName])) {
            return $this->onPropertyGet($this->properties[$propertyName]);
        } else {
            return null;
        }
    }

    /**
     * Used to apply properties with a PDO fetch request
     * @param $element
     * @param $primaryRequestElement
     * @return bool
     */
    public function patch($element)
    {
        $arrayWithTables = [];
        $tableName = $this->table->getTableName();

        foreach ($element as $key => $value) {
            // filter null values , prevent creating entites containing only null values
            if (is_null($value)) continue;

            if (strpos($key, '.') !== false) {
                $exploded = explode('.', $key);
                $table = $exploded[0];
                $column = $exploded[1];
            } else {
                $table = $tableName;
                $column = $key;
            }
            $arrayWithTables[$table][$column] = $value;
        }

        if (empty($this->properties)) {
            $this->set($arrayWithTables[$tableName]);
        }

        foreach ($arrayWithTables as $table => $properties) {
            if ($table !== $tableName)
                $this->{$table}[] = self::create($table, false, $properties);

        }

        return true;
    }

    /**
     * @param $tableName
     * @param bool $isNew
     * @param array $properties
     * @return Entity
     */
    public static function create($tableName, $isNew = true, $properties = [])
    {
        $entityClass = "Framework\Model\Entity\\" . substr($tableName, 0, -1);
        return new $entityClass($properties, $isNew);
    }

    /**
     *
     * @param array $fields
     */
    public function set(array $fields)
    {
        foreach ($fields as $field => $value) {
            if (isset($this->properties[$field])) {
                $this->properties[$field]->set($value);
                continue;
            }
            $prop = new EntityProperty($field, $value);
            $this->properties[$field] = $prop;
            $this->onPropertySet($prop);
        }
    }

    /**
     *
     * @throws Exception
     */
    public function delete()
    {
        $pKey = $this->getValidKey();

        $this->model->delete(
            QueryBuilder::delete()->where(Condition::make($pKey))
            , [$this->get($pKey)]
        );
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function getValidKey()
    {
        foreach ($this->table->getKeys() as $key) {
            if (!empty($this->get($key)))
                return $key;
        }

        throw new FatalErrorException("Cannot save , no valid key value set");
    }

    /**
     * @throws \Exception
     */
    public function exists()
    {
        try {
            $pKey = $this->getValidKey();
        } catch (Exception $e) {
            return false;
        }

        $exists = $this->model->get($this->get($pKey));

        return !empty($exists);
    }

    /**
     *
     * @throws \Exception
     */
    public function save()
    {
        if (!$this->exists()) {
            // INSERT STATEMENT
            $this->model->insert(
                QueryBuilder::insert()
                    ->from($this->table->getTableName())
                    ->columns($this->propertiesNames())
                , $this->propertiesToAssoc());
        } else {
            $pKey = $this->getValidKey();

            // UPDATE STATEMENT
            $this->model->update(
                QueryBuilder::update()
                    ->from($this->table->getTableName())->columns($this->dirtyPropertiesNames())->where(Condition::make($pKey, '=', 'pKey')
                    ), ['pKey' => $this->get($pKey)] + $this->dirtyPropertiesValues()
            );
        }
    }
}