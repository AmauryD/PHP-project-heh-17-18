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

class PostsController extends BaseController
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
            $post = $this->model->get($id);
            try {
                $post->delete();
                $this->view->flash("Post #{$post->get('id')} was successfully deleted");
                $this->redirect($this->referer);
            } catch (\Exception $exception) {
                $this->view->flash("Cannot post user #{$post->get('id')}", "error");
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