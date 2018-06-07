<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 05-05-18
 * Time: 20:07
 */

namespace Framework\Model\Validation;


class ValidationProperty
{
    private $name;
    private $value;
    private $errors;

    public function __construct($name, $value)
    {
        $this->errors = [];
        $this->name = $name;
        $this->value = $value;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function name()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    public function setType($type, $message = null)
    {
        return $this;
    }

    public function minLenght($lenght, $message = null)
    {
        if (!isset($message))
            $message = "{$this->name} must be more than $lenght characters";

        switch (true) {
            case is_int($this->value):
                if (strlen((string)abs($this->value)) < $lenght)
                    $this->errors[] = [__FUNCTION__, $message];
                break;
            default :
                if (strlen($this->value) < $lenght)
                    $this->errors[] = [__FUNCTION__, $message];
                break;
        }
        return $this;
    }

    public function maxLenght($lenght, $message = null)
    {
        if (!isset($message))
            $message = "{$this->name} must be less than $lenght characters";

        switch (true) {
            case is_int($this->value):
                if (strlen((string)abs($this->value)) > $lenght)
                    $this->errors[] = [__FUNCTION__, $message];
                break;
            default :
                if (strlen($this->value) > $lenght)
                    $this->errors[] = [__FUNCTION__, $message];
                break;
        }
        return $this;
    }

    public function custom(callable $func, $message = null)
    {
        if (!isset($message)) $message = "{$this->name} has an error";

        if (call_user_func($func, $this->value) !== true) $this->errors[] = [__FUNCTION__, $message];

        return $this;
    }

    public function allowEmpty($empty, $message = null)
    {
        if (!isset($message))
            $message = "{$this->name} must not be empty";

        if (!$empty)
            if (empty($this->value))
                $this->errors[] = [__FUNCTION__, $message];
        return $this;
    }
}