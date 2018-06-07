<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 17-02-18
 * Time: 19:48
 */

namespace Framework;

class Request {
    // HTTP request parameters
    private $parameters;

    /**
     * Request constructor.
     * @param array $parameters
     */
    public function __construct($parameters = []) {
        if (!$parameters)
            $parameters = array_merge($_GET, $_POST);
        $this->parameters = $parameters;
    }

    public function set($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    public function data($type = null)
    {
        return $this->parameters;
    }

    /**
     * @param $name
     * @return bool
     */
    public function is($name) {
        $name = strtoupper($name);
        return $_SERVER['REQUEST_METHOD'] === $name;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasParameter($name) {
        return !empty($this->parameters[$name]);
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getParameter($name) {
        if ($this->hasParameter($name))
            return $this->parameters[$name];
        else
            return null;
    }
}