<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 14-05-18
 * Time: 16:53
 */

namespace Framework\Controller\Admin;

use Framework\Database\QueryBuilder\QueryBuilder;
use framework\Exception\MissingParamException;
use framework\Exception\WrongMethodException;
use Framework\Model\Entity\Forum;
use template\Controller\BaseController;

class ForumsController extends BaseController
{
    /**
     * @throws \Exception
     */
    public function delete()
    {
        $this->noView();
        $id = $this->request->getParameter('id');

        if ($this->request->is('post')) {
            if (!$id)
                throw new MissingParamException("Need to provide a valid id");

            try {
                $forum = $this->model->get($id);
                $forum->delete();
                $this->view->flash("Forum {$forum->get('name')} deleted successfully");
                $this->redirect($this->referer);
            } catch (\Exception $exception) {
                $this->view->flash("Cannot delete this forum , please contact the webmaster");
                $this->redirect($this->referer);
            }
        } else {
            throw new WrongMethodException();
        }
    }

    /**
     *
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $name = $this->request->getParameter('name');

            $insertData = compact('name');

            $validation = $this->validate($insertData);

            if ($validation->hasErrors()) {
                foreach ($validation->errors() as $error) $this->view->flash($error[0][1], "error");
                return;
            }

            $forum = new Forum($insertData);

            try {
                $forum->save();
                $this->view->flash('Forum created successfully');
                $this->redirect(['action' => 'index']);
            } catch (\Exception $e) {
                $this->view->flash("Cannot add forum", "error");
            }
        }
    }

    /**
     * @throws MissingParamException
     */
    public function edit()
    {
        $id = $this->request->getParameter('id');

        if (!$id)
            throw new MissingParamException("Need to provide a valid id");

        $forum = $this->model->get($id);

        if ($this->request->is('post')) {
            $name = $this->request->getParameter('name');
            $insertData = compact('name');

            $validation = $this->validate($insertData);

            if ($validation->hasErrors()) {
                foreach ($validation->errors() as $error) $this->view->flash($error[0][1], "error");
                return;
            }

            try {
                $forum->set($insertData);
                $forum->save();
                $this->view->flash("Forum {$forum->get('name')} edited successfully");
                $this->redirect(['action' => 'index']);
            } catch (\Exception $exception) {
                $this->view->flash("Cannot edit this forum , please contact the webmaster");
                $this->redirect(['action' => 'index']);
            }
        }

        $this->view->set('forum', $forum);
    }

    /**
     * @throws \Exception
     */
    public function index()
    {
        $forums = $this->model->select(
            QueryBuilder::select()
                ->columns(['categories.id', 'forums.name', 'categories.name'])
                ->join('categories', 'forums.id', 'categories.forum_id', 'INNER')
        );
        $this->view->set('forums', $forums);
    }
}