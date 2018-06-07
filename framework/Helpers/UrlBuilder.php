<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 24-04-18
 * Time: 14:38
 */

namespace Framework\Helpers;

class UrlBuilder
{
    private $url = [];

    /**
     * UrlBuilder constructor.
     * @param string $controllerName
     */
    public function __construct($controllerName = '')
    {
        $this->url = [
            'controller' => $controllerName,
            'action' => '', 'prefix' => '',
            'params' => []
        ];
    }

    /**
     * @param array $url
     * @return string
     */
    public function make(array $url)
    {
        $url = array_merge($this->url, $url);
        $finalUrl = [];

        if (empty($url['action'])) $url['action'] = 'index';

        if (!empty($url['prefix'])) $finalUrl[] = $url['prefix'];

        $finalUrl[] = $url['controller'];
        $finalUrl[] = $url['action'];

        if (!empty($url['params'])) $finalUrl[] = implode('/', $url['params']);

        return BASE_URL . implode('/', $finalUrl);
    }

    public static function build(array $url)
    {
        $finalUrl = [];

        if (empty($url['action'])) $url['action'] = 'index';

        if (!empty($url['prefix'])) $finalUrl[] = $url['prefix'];

        $finalUrl[] = $url['controller'];
        $finalUrl[] = $url['action'];

        if (!empty($url['params'])) $finalUrl[] = implode('/', $url['params']);

        return BASE_URL . implode('/', $finalUrl);
    }
}