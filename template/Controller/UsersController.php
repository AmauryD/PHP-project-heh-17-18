<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 24-04-18
 * Time: 14:29
 */

namespace Framework\Controller;


use framework\Exception\WrongMethodException;
use Framework\Model\Entity\User;
use template\Controller\BaseController;

class UsersController extends BaseController
{
    protected function isAuthorized()
    {
        if ($this->action == 'profile') if (!isset($_SESSION['user']))
                return false;

        return parent::isAuthorized(); // TODO: Change the autogenerated stub
    }

    /**
     * @throws \Exception
     */
    public function login()
    {
        //already logged

        if (isset($_SESSION['user']))
            $this->redirect(['action' => 'index']);

        if ($this->request->is('post')) {
            $email = $this->request->getParameter('email');
            $password = $this->request->getParameter('password');

            $user = $this->model->get($email, 'email');

            if (!empty($user)) {
                if (password_verify($password, $user->get('password'))) {
                    $_SESSION['user'] = $user;
                    $this->view->flash("Successfully logged in<br>Welcome back <strong>{$user->get('firstname')}</strong>", "success");
                    $this->redirect(['action' => 'index']);
                }
                $this->view->flash("Password mismatch", "error");
            } else {
                $this->view->flash("No such user", "error");
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function add()
    {
        if($this->request->is('post'))
        {
            $firstname = $_POST['firstname'];
            $name = $_POST['name'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            $email = $_POST['email'];

            $validation = $this->validate($this->request->data());

            if ($validation->hasErrors()) {
                foreach ($validation->errors() as $error)
                    $this->view->flash($error[0][1], "error");
                return;
            }

            $user = new User(compact('firstname', 'name', 'password', 'email'));

            if (!$user->exists()) {
                $password_match = password_verify($password_confirm, $user->get('password'));
                if ($password_match) {
                    $user->save();
                    $this->view->flash("Thank's for your inscription <strong>{$user->get('firstname')}</strong> , you're ready to log in !", "success");
                    $this->redirect(['action' => 'index']);
                } else {
                    $this->view->flash("Passwords does not match", "error");
                }
            } else {
                $this->view->flash("User already exists", "error");
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function delete()
    {
        $this->noView();
        if ($this->request->is('post')) {
            $password = $this->request->getParameter("password");

            $user = $_SESSION['user'];

            if (password_verify($password,$user->get('password'))) {
                try {
                    $user->delete();
                    $this->view->flash("Your profile was successfully deleted");
                    unset($_SESSION['user']);
                } catch (\Exception $exception) {
                    $this->view->flash("Cannot delete your profile , please contact the webmaster", "error");
                }
            }else{
                $this->view->flash("Wrong password","error");
                $this->redirect(['action' => 'profile']);
            }

            $this->redirect(['action' => 'index']);
        }else{
            throw new WrongMethodException();
        }
    }

    /**
     * @throws \Exception
     */
    public function changePassword()
    {
        $this->noView();
        if ($this->request->is('post')) {
            $old_password = $this->request->getParameter("password_old");
            $password = password_hash($this->request->getParameter("password"),PASSWORD_DEFAULT);

            $user = $this->model->get($_SESSION['user']->get('id'));
            if (password_verify($old_password,$user->get('password'))) {
                $user->set(compact('password'));
                $user->save();
                $this->view->flash('Password changed');
            }else{
                $this->view->flash('Wrong Password','error');
            }
            $this->redirect($this->referer);
        }else{
            throw new WrongMethodException();
        }
    }

    public function profile()
    {
        if ($this->request->is('post')) {
            $firstname = $this->request->getParameter('firstname');
            $name = $this->request->getParameter('name');
            $user = $_SESSION['user'];
            $user->set(compact('firstname', 'name')
            );
            try {
                $user->save();
            } catch (\Exception $e) {
                echo $e->getMessage();
                $this->view->flash('Cannot save user', 'error');
            }
        }
    }

    public function logout()
    {
        $this->noView(true);
        session_destroy();
        $this->redirect(['action' => 'index']);
    }

    /**
     * @throws \Exception
     */
    public function index()
    {
        $users = $this->model->select();
        $this->view->set('users', $users);
    }
}