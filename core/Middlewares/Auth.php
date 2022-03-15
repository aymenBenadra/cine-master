<?php

namespace Core\Middlewares;

use Core\Router;

/**
 * Auth class
 * - Handle the request
 * - Redirect to login page if unauthorized
 * 
 * 
 * @package    Core
 * @author     Mohammed-Aymen Benadra
 * 
 */
class Auth
{
    /**
     * Handle Authentication
     * 
     * @param  mixed $role
     * @return ?boolean
     */
    public function handle($role)
    {
        // Start Session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;

        switch ($role) {
            case 'guest':
                if (!$user) {
                    return true;
                }
                break;
            case 'user':
                if ($user) {
                    return true;
                }
                break;
            case 'admin':
                if ($user->admin) {
                    return true;
                }
                break;

            default:
                break;
        }

        // Redirect to login page if guest and to home page if user
        if(!$user) {
            Router::redirect('/login', ['error' => 'You must be logged in to access this page']);
        } else {
            Router::redirect('/');
        }

        return false;
    }
}
