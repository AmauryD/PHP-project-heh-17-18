<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 21-02-18
 * Time: 09:59
 */

namespace Framework;

class Autoload
{
    private static $dirs = [];
    private static $cache = [];

    /**
     *
     */
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoLoadClass']);
    }

    /**
     * @param $dirPath
     */
    public static function registerDir($dirPath)
    {
        if (is_dir($dirPath))
            self::$dirs[$dirPath] = $dirPath;
    }

    /**
     * @param array $dirs
     */
    public static function registerDirs(array $dirs)
    {
        foreach ($dirs as $dir)
            self::registerDir($dir);
    }

    /**
     * @param $class
     */
    private static function autoLoadClass($class){

        $str_pos = strrpos($class,"\\");

        ($str_pos !== FALSE) ? $className = substr($class,$str_pos  + 1) : $className = $class;

        if (array_key_exists($class,self::$cache)) {
            require_once self::$cache[$class];
            return;
        }

        foreach (self::$dirs as $dir)
        {
            $path = str_replace('\\', DIRECTORY_SEPARATOR, ROOT_DIR.$dir.'\\'.$className.".php");
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }
}