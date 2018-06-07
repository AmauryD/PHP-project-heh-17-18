<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 27-02-18
 * Time: 16:01
 */

namespace Framework;


use DateTime;

class Functions
{
    /**
     * @param $class
     * @return bool|string
     */
    public static function getClassName($class)
    {
        $thisClass = get_class($class);
        $str_pos = strrpos($thisClass,"\\");

        return ($str_pos !== FALSE) ? substr($thisClass,$str_pos  + 1) : $thisClass;
    }

    public static function entityNameFromController($name)
    {
        return str_replace('sController', '', $name);
    }

    public static function isDatetimeValid($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}