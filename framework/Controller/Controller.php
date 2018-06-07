<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 17-02-18
 * Time: 17:26
 * This framework : "Make a tank to kill a fly"
 */

namespace Framework\Controller;

use Exception;
use Framework\Config\ConfigReader;
use Framework\Database\ModelQuery;
use Framework\Exception\NotFoundException;
use Framework\Functions;
use Framework\Helpers\UrlBuilder;
use Framework\Model\Table\TableRegistry;
use Framework\Model\Validation\Validator;
use Framework\Request;
use Framework\Session\SessionManager;
use Framework\View\View;

abstract class Controller
{
    protected $request;
    protected $action;
    protected $name;

    private $prefix;

    /* @var View $view */
    protected $view;
    private $noView = false;

    /* @var SessionManager $sessionHandler */
    protected $sessionHandler;

    /* @var ModelQuery $model */
    protected $model;
    /* @var UrlBuilder $urlbuilder */
    protected $urlBuilder;
    protected $referer;

    public abstract function index();

    /**
     * Controller constructor.
     * @param Request $request
     * @throws Exception
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->name = str_replace('Controller', '', Functions::getClassName($this));
        $this->prefix = $this->request->getParameter('prefix');
        $this->model = $this->loadModel($this->name);
        $this->urlBuilder = new UrlBuilder($this->name);
        $this->sessionHandler = new SessionManager();
        $this->referer = isset($_SERVER['HTTP_REFERER'])
            ? $_SERVER['HTTP_REFERER']
            : UrlBuilder::build(['controller' => ConfigReader::read('routing', 'defaultController'), 'action' => 'index']);
        $this->initialize();
    }

    /**
     * @param $data
     * @return Validator
     */
    protected function validate($data)
    {
        return Validator::create(Functions::entityNameFromController($this->name), $data, $this->action);
    }

    /**
     * @param $modelName
     * @return ModelQuery
     */
    protected function loadModel($modelName)
    {
        return $this->{$this->name} = new ModelQuery(TableRegistry::get($modelName));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * @param bool $noView
     */
    public function noView($noView = true)
    {
        $this->noView = $noView;
    }

    /**
     * Initialize method for other controllers
     * @throws Exception
     */
    protected function initialize()
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
    }

    /**
     * @throws Exception
     */
    protected function beforeAction()
    {
        if (!$this->isAuthorized()) {
            $this->view->flash("You are not authorized", 'error');
            $this->redirect(["controller" => 'Users', 'action' => 'login']);
        }
    }

    /**
     * Sets the alert block in layout
     * @param $name
     */
    protected function alert($name)
    {
        $this->view->addBlock('error',$name);
    }


    /**
     * @param $url
     */
    protected function redirect($url)
    {
        if (is_array($url))
            $url = $this->urlBuilder->make($url);

        header("Location: " . $url);
        exit();
    }


    /**
     * Checks if the user can render page
     * @return bool
     */
    protected function isAuthorized()
    {
        return true;
    }

    /**
     * Execute a controller action
     * @param $action
     * @throws Exception
     */
    public function executeAction($action)
    {
        if (method_exists($this, $action)) {
            $this->action = $action;
            $this->view = new View(
                $this->name,
                $action,
                $this->prefix
            );
            $this->beforeAction();
            $this->$action();
            if (!$this->noView)
                $this->view->display();
        } else {
            throw new NotFoundException("Action $action does not exists");
        }
    }
}