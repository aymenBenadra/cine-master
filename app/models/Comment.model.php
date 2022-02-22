<?php

namespace App\Models;

use Core\Model;
use PDO;

/**
 * Comment Model
 * 
 * @package App\Models
 * @uses Core\Model Core Model
 * @author Mohammed-Aymen Benadra
 */
class Comment extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'Comments';
    }
}
