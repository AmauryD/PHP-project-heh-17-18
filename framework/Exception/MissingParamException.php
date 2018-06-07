<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 13-05-18
 * Time: 15:38
 */

namespace framework\Exception;

class MissingParamException extends Exception
{
    protected $title = "Missing parameter";
}