<?php

namespace App\Models;

use Core\Model;

/**
 * User Model
 * 
 * @package App\Models
 * @uses Core\Model Core Model
 * @author Mohammed-Aymen Benadra
 */
class User extends Model
{
    public function __construct()
    {
        parent::__construct([
            'id' => 'numeric',
            'username' => 'required|string|min:3|max:45',
            'email' => 'required|email|min:10|max:100',
            'password' => 'required|string|min:6|max:45',
            'admin' => 'bool',
            'avatar' => 'required|string'
        ]);
        $this->table = 'Users';
    }
}
