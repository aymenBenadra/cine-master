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
        parent::__construct([
            'id' => 'int',
            'author_id' => 'required|int',
            'title' => 'required|string|min:3|max:100',
            'photo' => 'required|string',
            'description' => 'required|string|min:3|max:1000',
            'category_id' => 'required|int',
            'created_at' => 'date',
            'updated_at' => 'date'
        ]);
        $this->table = 'Posts';
    }
}
