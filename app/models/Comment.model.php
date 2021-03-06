<?php

namespace App\Models;

use Core\Model;

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
        parent::__construct([
            'id' => 'numeric',
            'post_id' => 'required|numeric',
            'author_id' => 'required|numeric',
            'content' => 'required|string',
            'created_at' => 'date'
        ]);
        $this->table = 'Comments';
    }
}
