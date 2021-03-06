<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 18-04-18
 * Time: 11:07
 */

namespace Framework\Controller;


use framework\Exception\MissingParamException;
use Framework\Exception\NotFoundException;
use Framework\Model\Entity\Post;
use template\Controller\BaseController;

class PostsController extends BaseController
{
    protected function isAuthorized()
    {
        if (!isset($_SESSION['user']))
            return false;
        return parent::isAuthorized(); // TODO: Change the autogenerated stub
    }

    /**
     * @throws \Exception
     */
    public function index()
    {

    }

    public function add()
    {
        if ($this->request->is('post')) {
            $user_id = $_SESSION['user']->get('id');
            $topic_id = $this->request->getParameter('id');
            $content = $this->request->getParameter('content');

            $insertData = compact('user_id', 'topic_id', 'content');

            $validation = $this->validate($insertData);

            if ($validation->hasErrors()) {
                foreach ($validation->errors() as $error) $this->view->flash($error[0][1], "error");
                return;
            }

            $post = new Post($insertData);

            try {
                $post->save();
                $this->view->flash('Post created successfully');
                $this->redirect(['controller' => 'topics', 'action' => 'view', 'params' => [$topic_id]]);
            } catch (\Exception $e) {
                $this->view->flash("Cannot save post", "error");
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function edit()
    {
        $id = $this->request->getParameter('id');

        if (!$id) throw new MissingParamException("Parameter id is not set");

        $post = $this->model->get($id);

        if (empty($post)) throw new NotFoundException("Post does not exists");

        if ($post->get('user_id') !== $_SESSION['user']->get('id'))
        {
            $this->view->flash("You're not the owner");
            $this->redirect($this->referer);
        }

        if ($this->request->is('post')) {
            $content = $this->request->getParameter('content');

            $insertData = compact('content');

            $validation = $this->validate($insertData);

            if ($validation->hasErrors()) {
                foreach ($validation->errors() as $error) $this->view->flash($error[0][1], "error");
                return;
            }

            $post->set($insertData);

            try {
                $post->save();
                $this->view->flash('Post edited successfully');
                $this->redirect(['controller' => 'topics', 'action' => 'view', 'params' => [$post->get('topic_id')]]);
            } catch (\Exception $e) {
                $this->view->flash("Cannot edit post", "error");
            }
        }

        $this->view->set('post', $post);
    }

    public function delete()
    {

    }
}