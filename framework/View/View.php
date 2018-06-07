<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 18-02-18
 * Time: 16:36
 */

namespace Framework\View;

use Exception;
use framework\Exception\FatalErrorException;
use Framework\Helpers\HtmlHelper;
use Framework\Session\FlashRenderer;

class View
{
    protected $action;
    protected $controllerName;
    protected $layout = "default";
    private $prefix;

    protected $Html;
    protected $Flash;

    protected $viewBlocks;
    protected $parameters;

    /**
     * View constructor.
     * @param $controller
     * @param $action
     * @param null $prefix
     */
    public function __construct($controller, $action, $prefix = null)
    {
        $this->prefix = $prefix;
        $this->viewBlocks = new ViewBlock();
        $this->parameters = [];
        $this->Flash = new FlashRenderer($this);
        $this->controllerName = $controller;
        $this->action = $action;
        $this->Html = new HtmlHelper($controller,$action);

        $this->set('title', "$controller - $action");
    }

    public function flash($message, $type = 'success')
    {
        $this->Flash->flash($message, $type);
    }

    /**
     * Get a view block
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function getBlock($name)
    {
        if($this->viewBlocks->hasBlock($name))
            return $this->viewBlocks->get($name);
        else
            return '';
    }

    /**
     * Add/Set a view block
     * @param $name
     * @param $content
     */
    public function addBlock($name, $content)
    {
        $this->viewBlocks->set($name,$content);
    }

    /**
     * Set current layout name
     * @param $layerName
     */
    public function setLayout($layerName)
    {
        $this->layout = $layerName;
    }

    /**
     * Set a view parameter
     * @param $varName
     * @param $value
     */
    public function set($varName, $value)
    {
        $this->parameters[$varName] = $value;
    }

    /**
     * Gets the content of a file
     * @param $viewFile
     * @param $dataForView
     * @return string
     */
    public function evaluate($viewFile, $dataForView = [])
    {
        extract($dataForView);
        ob_start();
        include func_get_arg(0);
        return ob_get_clean();
    }

    /**
     * @param $block
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function loadBlock($block, $data = [])
    {
        $path = "template/Blocks/$block.php";

        if (!file_exists($path))
            throw new Exception("Block $block does not exists");

        $this->addBlock($block, $this->evaluate($path, $data));
        return $this->viewBlocks->get($block);
    }

    /**
     * @param $file
     * @param $dataForView
     */
    public function render($file, $dataForView)
    {
        echo $this->evaluate($file,$dataForView);
    }

    /**
     * Render View to screen
     * @throws Exception
     */
    public function display()
    {
        if (!isset($this->prefix))
            $viewPath = ROOT_DIR . "template\View\\" . $this->controllerName . DIRECTORY_SEPARATOR . $this->action . '.php';
        else
            $viewPath = ROOT_DIR . "template\View\\$this->prefix\\" . $this->controllerName . DIRECTORY_SEPARATOR . $this->action . '.php';

        $layPath = ROOT_DIR."template\Template\Layout\\".$this->layout.'.php';

        if (file_exists($viewPath) && file_exists($layPath))
        {
            $this->addBlock("content",
                $this->evaluate($viewPath,$this->parameters)
            );
            $this->render($layPath,$this->parameters);
        }else{
            throw new FatalErrorException("View does not exists");
        }
    }
}