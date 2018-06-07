<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 20-02-18
 * Time: 14:42
 */

namespace Framework\Config;

class ConfigReader
{
    private static $configFile;

    /**
     * Read key from .ini config file , if configFile does not exists , set it
     * @param $key
     * @param null $subKey
     * @return mixed
     */
    static public function read($key, $subKey = null)
    {
        if (!isset(self::$configFile))
            self::$configFile = parse_ini_file(ROOT_DIR.'config/global.ini',true);

        if (isset($subKey))
            return self::$configFile[$key][$subKey];

        return self::$configFile[$key];
    }
}