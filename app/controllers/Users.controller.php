<?php

namespace App\Controllers;

use Core\{Controller, Router};
use Exception;

class Users extends Controller
{
    private $model;

    /**
     * Initialize User model
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = $this->model('User');
    }

    /**
     * Login page
     * 
     * @param  mixed $status
     * @return boolean
     */
    public function login($status = null)
    {
        if ($status) {
            $this->view('users/login', $status);
        } else {
            $this->view('users/login');
        }
    }

    /**
     * Register page
     * 
     * @param  mixed $status
     * @return boolean
     */
    public function register($status = null)
    {
        if ($status) {
            $this->view('users/register', compact('status'));
        } else {
            $this->view('users/register');
        }
    }

    /**
     * Login user and redirect to home page if success or to login page if failed with error message
     * 
     * @param  array $data
     * @return void
     */
    public function signin($data)
    {
        extract($data);

        if (!isset($login) || !isset($password) || empty($login) || empty($password)) {
            $error = "Please fill all fields";
            $this->view('users/login', compact('error'));
        }

        $field = str_contains($login, '@') ? 'email' : 'username';

        $user = $this->model->getBy($field, $login);

        if ($user) {
            if (password_verify($password, $user->password)) {
                session_start();
                $_SESSION['user'] = serialize($user);
                Router::redirect('/');
            } else {
                $error = "Wrong password";
                $this->view('users/login', compact('error'));
            }
        } else {
            $error = "Username or password is incorrect";
            $this->view('users/login', compact('error'));
        }
    }

    /**
     * Register user and redirect to login page if success or to register page if failed with error message
     * 
     * @param  array $data
     * @return void
     */
    public function signup($data)
    {
        extract($data);

        if (!isset($username) || !isset($email) || !isset($password) || !isset($password_confirm) || empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
            $error = "Please fill all fields";
            $this->view('users/register', compact('error'));
            exit;
        }

        if ($password !== $password_confirm) {
            $error = "Passwords do not match";
            $this->view('users/register', compact('error'));
            exit;
        }

        $user = $this->model->getBy('email', $email);

        if ($user) {
            $error = "Email is already taken";
            $this->view('users/register', compact('error'));
            exit;
        }

        $user = $this->model->getBy('username', $username);

        if ($user) {
            $error = "Username is already taken";
            $this->view('users/register', compact('error'));
            exit;
        }

        $user = $this->model->add([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'admin' => 0
        ]);

        if ($user) {
            $status = true;
            Router::redirect('login', compact('status'));
        } else {
            $error = "Arrgh! Something went wrong";
            $this->view('users/register', compact('error'));
            exit;
        }
    }

    /**
     * Go to User Profile page if logged in or to login page if not
     *
     * @param  mixed $data
     * @return void
     */
    public function profile()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            $this->view('users/profile', compact('user'));
        } else {
            $this->view('users/login');
        }
    }

    /**
     * Go to Post creation page
     *
     * @return void
     */
    public function create()
    {
        $this->view('posts/create');
    }

    /**
     * Go to Post edit page
     *
     * @param  mixed $data
     * @return void
     */
    public function edit($data = [])
    {
        try {
            if (empty($data) || !isset($data['id'])) {
                throw new Exception('Post ID is not specified');
            }

            extract($data);

            $post = $this->model->get($id);

            if (!$post) {
                throw new Exception('Post does not exist');
            } else {
                $this->view('posts/edit', compact('id', 'post'));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Store new Post record in database
     *
     * @param  mixed $data
     * @return void
     */
    public function store($data = [])
    {
        try {
            if (empty($data) || !isset($data['title'])) {
                throw new Exception('Post data is not specified');
            }

            if (!$this->model->add($data)) {
                throw new Exception('Arrgh! Something went wrong');
            } else {
                Router::redirect('/public/post?id=' . $this->model->getLastInsertedId());
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Update existing Post in database
     *
     * @param  mixed $data
     * @return void
     */
    public function update($data = [])
    {
        try {
            if (empty($data['id']) || !isset($data['id'])) {
                throw new Exception('Post ID is not specified');
            } else if (!isset($data['title']) || empty($data['title'])) {
                throw new Exception('Post title is not specified');
            }

            extract($data);

            if (!$this->model->update($id, compact('title'))) {
                throw new Exception('Arrgh! Something went wrong');
            } else {
                Router::redirect('/public/post?id=' . $id);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Delete Post from database
     *
     * @param  mixed $data
     * @return void
     */
    public function delete()
    {
        $this->view('posts/delete');
    }

    /**
     * Destroy Post from database
     *
     * @param  mixed $data
     * @return void
     */
    public function destroy($data = [])
    {
        try {
            if (empty($data) || !isset($data['id'])) {
                throw new Exception('Post ID is not specified');
            }

            extract($data);

            if (!$this->model->delete($id)) {
                throw new Exception('Arrgh! Something went wrong');
            } else {
                Router::redirect('/public/posts');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
