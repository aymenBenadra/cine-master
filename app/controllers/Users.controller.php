<?php

namespace App\Controllers;

use Core\{Controller, Router};
use Exception;

/**
 * Users Controller
 *
 * @author Mohammed-Aymen Benadra
 * @package App\Controllers
 */
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
                unset($user->password);
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

        // Check if user with same username or email exists
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
            'admin' => 0,
            'avatar' => $this->uploadPhoto($avatar)
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
     * Logout user and redirect to home page
     * 
     * @return void
     */
    public function logout()
    {
        session_start();
        session_destroy();
        Router::redirect('/');
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
            $posts = $this->model('Post')->getAllBy('author_id', $user->id);
            if ($posts) {
                $this->view('users/profile', compact('user', 'posts'));
            } else {
                $this->view('users/profile', compact('user'));
            }
        } else {
            $this->view('users/login');
        }
    }

    /**
     * Go to User edit page
     *
     * @param  mixed $data
     * @return void
     */
    public function edit($data = [])
    {
        try {
            if (empty($data) || !isset($data['id'])) {
                throw new Exception('User ID is not specified');
            }

            extract($data);

            $user = $this->model->get($id);

            if (!$user) {
                throw new Exception('User does not exist');
            } else {
                session_start();
                $this->view('users/editProfile', compact('user'));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Update existing User in database
     *
     * @param  mixed $data
     * @return void
     */
    public function update($data = [])
    {
        try {
            if (empty($data['id']) || !isset($data['id'])) {
                throw new Exception('User ID is not specified');
            } else if (!isset($data['username']) || empty($data['username'])) {
                throw new Exception('User username is not specified');
            } else if (!isset($data['email']) || empty($data['email'])) {
                throw new Exception('User email is not specified');
            } else {

                $user = $this->model->get($data['id']);

                // handle avatar upload if exists in data array and update user
                if (isset($data['avatar'])) {
                    $data['avatar'] = $this->uploadPhoto($data['avatar']);
                } else {
                    $data['avatar'] = $user->avatar;
                }

                if (!$user) {
                    throw new Exception('User does not exist');
                } else {
                    $id = $data['id'];
                    unset($data['id']);

                    if ($this->model->update($id, $data)) {
                        // update session user
                        $user = $this->model->get($id);
                        unset($user->password);
                        session_start();
                        $_SESSION['user'] = serialize($user);
                        Router::redirect('/profile');
                    } else {
                        throw new Exception('User could not be updated');
                    }
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Destroy User from database
     *
     * @param  mixed $data
     * @return void
     */
    public function destroy($data = [])
    {
        try {
            if (empty($data) || !isset($data['id'])) {
                throw new Exception('User ID is not specified');
            }

            extract($data);

            if (!$this->model->delete($id)) {
                throw new Exception('Arrgh! Something went wrong');
            } else {
                Router::redirect('/register');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
