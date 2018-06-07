<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 06-05-18
 * Time: 10:52
 */

namespace Framework\Exception;

class NotFoundException extends Exception
{
    protected $title = "Not Found";
}