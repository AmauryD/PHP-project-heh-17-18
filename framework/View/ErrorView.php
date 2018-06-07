<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 25-02-18
 * Time: 10:57
 */

namespace Framework\View;

use Exception;
use framework\Exception\FatalErrorException;

class ErrorView extends View
{
    /* @var Exception $exception */
    private $exception;

    public function __construct($controller, $action, Exception $exception)
    {
        parent::__construct($controller, $action);
        $this->exception = $exception;
        $this->setLayout('error');
        $this->set('title', 'error');
    }

    public function display()
    {
        $layPath = ROOT_DIR . "template\Template\Layout\\" . $this->layout . '.php';

        if (file_exists($layPath)) {
            if ($this->exception instanceof \framework\Exception\Exception) {
                $this->set('title', $this->exception->title());
            } else {
                $this->set('title', 'Error');
            }
            $this->set('message', $this->exception->getMessage());
            $this->render($layPath, $this->parameters);
        } else {
            throw new FatalErrorException("No error view set");
        }
    }
}