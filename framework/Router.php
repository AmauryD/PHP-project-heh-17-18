<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 17-02-18
 * Time: 19:49
 */

namespace Framework;

use Exception;
use Framework\Config\ConfigReader;
use Framework\Exception\NotFoundException;
use Framework\View\ErrorView;

class Router
{
    /**
     * @param Request $request
     * @throws Exception
     */
    public function route(Request $request)
    {
        try {
            $controller = $this->getController($request);
            $controller->executeAction($this->getAction($request));
        } catch (Exception $exception) {
            $errorView = new ErrorView('', '', $exception);
            $errorView->display();
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    private function getController(Request $request)
    {
        $controller_name = (empty($request->getParameter('controller'))
                ? ConfigReader::read('routing', 'defaultController')
                : $request->getParameter('controller')) . 'Controller';

        if (!$request->hasParameter('prefix')) {
            $path = ROOT_DIR . "template\Controller\\$controller_name.php";
            $class = '\Framework\Controller\\' . $controller_name;
        } else {
            $prefix = $request->getParameter('prefix');
            $class = "\Framework\Controller\\$prefix\\$controller_name";
            $path = ROOT_DIR . "template\Controller\\$prefix\\$controller_name.php";
        }

        if(!file_exists($path))
            throw new NotFoundException("Controller does not exists");

        require_once $path;

        return new $class($request);
    }

    /**
     * @param Request $request
     * @return mixed|string
     */
    private function getAction(Request $request)
    {
        $action = "index";

        if ($request->hasParameter('action'))
            $action = $request->getParameter('action');

        return $action;
    }

}