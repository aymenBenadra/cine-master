<?php

namespace App\Models;

use Core\Model;

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
            'id' => 'numeric',
            'author_id' => 'required|numeric',
            'title' => 'required|string|min:3|max:100',
            'photo' => 'required|image',
            'description' => 'required|string|min:3|max:1000',
            'category_id' => 'required|numeric',
            'created_at' => 'date',
            'updated_at' => 'date'
        ]);
        $this->table = 'Posts';
    }
}
