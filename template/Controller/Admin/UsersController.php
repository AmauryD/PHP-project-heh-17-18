<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 15-05-18
 * Time: 13:30
 */

namespace Framework\Controller\Admin;

use Framework\Database\DatabaseConnection;
use framework\Exception\MissingParamException;
use Framework\Exception\NotFoundException;
use framework\Exception\WrongMethodException;
use template\Controller\BaseController;


class UsersController extends BaseController
{
    /**
     * @throws MissingParamException
     * @throws NotFoundException
     */
    public function edit()
    {
        $id = $this->request->getParameter('id');

        if (!$id) throw new MissingParamException("Parameter id is not set");

        $user = $this->model->get($id);

        if (empty($user)) throw new NotFoundException("User does not exists");

        if ($this->request->is('post')) {
            $role = $this->request->getParameter('role');
            $name = $this->request->getParameter('name');
            $firstname = $this->request->getParameter('firstname');

            $insertData = compact('role', 'name', 'firstname');

            if (!in_array($role, ["admin", "member"])) {
                // don't have time to make custom separate validation rules
                $this->view->flash("Wrong role , must be 'admin' or 'member'", "error");
                $this->view->set('user', $user);
                return;
            }

            $user->set($insertData);

            try {
                $user->save();
                $this->view->flash('User edited successfully');
                $this->redirect(['controller' => 'users', 'action' => 'index']);
            } catch (\Exception $e) {
                $this->view->flash("Cannot edit user", "error");
            }
        }

        $this->view->set('user', $user);
    }

    /**
     * @throws \Exception
     */
    public function index()
    {
        $users = $this->model->select();
        $this->view->set('users', $users);
    }

    /**
     * @throws MissingParamException
     * @throws WrongMethodException
     */
    public function delete()
    {
        $this->noView();
        $id = $this->request->getParameter('id');

        if (!$id) throw new MissingParamException();

        if ($this->request->is('post')) {
            $user = $this->model->get($id);
            try {
                $user->delete();
                $this->view->flash("User {$user->get('firstname')} was successfully deleted");
                $this->redirect($this->referer);
            } catch (\Exception $exception) {
                $this->view->flash("Cannot delete user {$user->get('firstname')}", "error");
            }
        } else {
            throw new WrongMethodException();
        }
    }
}