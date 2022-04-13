<?php

namespace App\Controllers;

use Core\{Controller, Router};

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

        $field = str_contains($login, '@') ? 'email' : 'username';

        $user = $this->model->getBy($field, $login);

        if ($user) {
            if (password_verify($password, $user->password)) {
                unset($user->password);
                // Start Session
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user'] = serialize($user);
                Router::redirect('/');
            } else {
                Router::redirect('/login', ['error' => 'Wrong password']);
            }
        } else {
            Router::redirect('/login', ['error' => 'User not found']);
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

        if ($password !== $password_confirm) {
            Router::redirect('/users/register', compact(['error' => 'Passwords do not match']));
        }

        // Check if user with same username or email exists
        $user = $this->model->getBy('email', $email);

        if ($user) {
            Router::redirect('/users/register', compact(['error' => 'Email is already taken']));
        }

        $user = $this->model->getBy('username', $username);

        if ($user) {
            Router::redirect('/users/register', compact(['error' => 'Username is already taken']));
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
            Router::redirect('/users/register', compact(['error' => 'Something went wrong']));
        }
    }

    /**
     * Logout user and redirect to home page
     * 
     * @return void
     */
    public function logout()
    {
        // Start Session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
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
        // Start Session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
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
     * @return void
     */
    public function edit()
    {
        // Start Session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $user = unserialize($_SESSION['user']);

        $user = $this->model->get($user->id);

        if (!$user) {
            Router::abort(404, 'User not found');
        } else {
            // Start Session
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->view('users/editProfile', compact('user'));
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
        $user = $this->model->get($data['id']);

        $data['avatar'] = $this->uploadPhoto($data['avatar']);

        if (!$user) {
            Router::abort(404, 'User not found');
        } else {
            $id = $data['id'];
            unset($data['id']);

            if ($this->model->update($id, $data)) {
                // update session user
                $user = $this->model->get($id);
                unset($user->password);
                // Start Session
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user'] = serialize($user);
                Router::redirect('/profile');
            } else {
                Router::abort(500, 'Something went wrong');
            }
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
        if (!$this->model->delete($data['id'])) {
            Router::abort(500, 'Something went wrong');
        } else {
            Router::redirect('/logout');
        }
    }
}
