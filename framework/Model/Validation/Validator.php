<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 05-05-18
 * Time: 20:04
 */

namespace Framework\Model\Validation;

// used to validate form data
abstract class Validator
{
    private $data = [];
    private $fields = [];

    /**
     * Validator constructor.
     * Validates post data from form fields
     * @param $data
     * @param string $validation
     */
    public function __construct($data, $validation = 'base')
    {
        $this->data = $data;
        $this->initialize();
        $this->$validation();
    }

    /**
     * @return mixed
     */
    protected function initialize()
    {

    }

    /**
     * @param string $name
     * @param array $data
     * @param string $validationType
     * @return Validator
     */
    public static function create($name, $data, $validationType)
    {
        $name = "{$name}Validation";
        $namespace = "Framework\Model\Validation\\$name";
        return new $namespace($data, $validationType);
    }

    /**
     * @param $field
     * @return mixed
     * @throws \Exception
     */
    public function field($field)
    {
        if (!array_key_exists($field, $this->fields))
            throw new \Exception("Field $field does not exists");
        return $this->fields[$field];
    }

    /**
     * check if validator has errors
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->errors());
    }

    /**
     * get all errors for all fields
     * @return array
     */
    public function errors()
    {
        $arr = [];
        foreach ($this->fields as $property) {
            if ($property->hasErrors())
                $arr[$property->name()] = $property->errors();
        }
        return $arr;
    }

    /**
     * @param $fieldName
     * @return ValidationProperty
     */
    public function registerField($fieldName)
    {
        return $this->fields[$fieldName] = new ValidationProperty($fieldName,
            isset($this->data[$fieldName]) ? $this->data[$fieldName] : null
        );
    }
}