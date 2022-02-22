<?php

namespace App\Models;

use Core\Model;
use PDO;

/**
 * Post Model
 * 
 * @package App\Models
 * @uses Core\Model Core Model
 * @author Mohammed-Aymen Benadra
 */
class Post extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'Posts';
    }
}
