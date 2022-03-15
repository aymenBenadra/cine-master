<?php

use App\Models\{Comment, Post, User};

/**
 * Validation Rules
 * 
 * @package App\Config
 * @author Mohammed-Aymen Benadra
 */

$user = new User();
$post = new Post();
$comment = new Comment();

return array_merge(
    $user->getRequiredSchema(),
    $post->getRequiredSchema(),
    $comment->getRequiredSchema(),
    ['id'=>'required|numeric','password_confirm' => 'required|string|min:6|max:45', 'login' => 'required|string|min:3|max:100']
);
