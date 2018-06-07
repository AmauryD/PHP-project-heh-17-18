<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 15-05-18
 * Time: 17:09
 */

namespace Framework\Controller\Admin;


use framework\Exception\MissingParamException;
use framework\Exception\WrongMethodException;
use template\Controller\BaseController;

class TopicsController extends BaseController
{
    /**
     * @throws MissingParamException
     * @throws WrongMethodException
     * @throws \Exception
     */
    public function delete()
    {
        $this->noView();
        $id = $this->request->getParameter('id');

        if (!$id) throw new MissingParamException();

        if ($this->request->is('post')) {
            $topic = $this->model->get($id);
            try {
                $topic->delete();
                $this->view->flash("Topic #{$topic->get('id')} was successfully deleted");
                $this->redirect(['controller' => 'topics', 'action' => 'index', 'params' => [$topic->get('category_id')]]);
            } catch (\Exception $exception) {
                $this->view->flash("Cannot delete post #{$topic->get('id')}", "error");
            }
        } else {
            throw new WrongMethodException();
        }
    }

    public function index()
    {
        // TODO: Implement index() method.
    }
}