<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 19-05-18
 * Time: 15:48
 */

namespace framework\Controller\Admin;


use framework\Exception\MissingParamException;
use framework\Exception\WrongMethodException;
use Framework\Model\Entity\Categorie;
use template\Controller\BaseController;

class CategoriesController extends BaseController
{
    public function edit()
    {
        $id = $this->request->getParameter('id');

        if (!$id) throw new MissingParamException("Need to provide a valid id");

        $category = $this->model->get($id);

        if ($this->request->is('post')) {
            $name = $this->request->getParameter('name');
            $insertData = compact('name');

            $validation = $this->validate($insertData);

            if ($validation->hasErrors()) {
                foreach ($validation->errors() as $error) $this->view->flash($error[0][1], "error");
                return;
            }

            try {
                $category->set($insertData);
                $category->save();
                $this->view->flash("Category {$category->get('name')} edited successfully");
                $this->redirect($this->referer);
            } catch (\Exception $exception) {
                $this->view->flash("Cannot edit this category , please contact the webmaster");
                $this->redirect($this->referer);
            }
        }

        $this->view->set('category', $category);
    }

    public function add()
    {
        $forum_id = $this->request->getParameter('id');

        if (!$forum_id) throw new MissingParamException("Need to provide a valid id");

        if ($this->request->is('post')) {
            $name = $this->request->getParameter('name');

            $insertData = compact('name', 'forum_id');

            $validation = $this->validate($insertData);

            if ($validation->hasErrors()) {
                foreach ($validation->errors() as $error) $this->view->flash($error[0][1], "error");
                return;
            }

            $category = new Categorie($insertData);

            try {
                $category->save();
                $this->view->flash('Category created successfully');
                $this->redirect(['controller' => 'forums', 'action' => 'index']);
            } catch (\Exception $e) {
                $this->view->flash("Cannot add category", "error");
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function delete()
    {
        $this->noView();
        $id = $this->request->getParameter('id');

        if ($this->request->is('post')) {
            if (!$id) throw new MissingParamException("Need to provide a valid id");

            try {
                $category = $this->model->get($id);
                $category->delete();
                $this->view->flash("Category {$category->get('name')} deleted successfully");
                $this->redirect($this->referer);
            } catch (\Exception $exception) {
                $this->view->flash("Cannot delete this category , please contact the webmaster");
                $this->redirect($this->referer);
            }
        } else {
            throw new WrongMethodException();
        }
    }
}