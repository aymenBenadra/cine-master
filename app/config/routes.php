<?php

/**
 * *Users Controller
 * path: app\controllers\Users.controller.php
 * 
 * - GET Routes
 * - POST Routes
 */
// Login page
$router->get('login', 'Users@login');
// Register page
$router->get('register', 'Users@register');
// Profile page
$router->get('profile', 'Users@profile');

//-------------------------------------------------------------------------------------------------------------//

// Login user and redirect to home page if success or to login page if failed with error message
$router->post('signin', 'Users@signin');
// Register user and redirect to login page if success or redirect to register page if failed with error message
$router->post('signup', 'Users@signup');

/**
 * *Posts Controller
 * path: app\controllers\Posts.controller.php
 * 
 * - GET Routes
 * - POST Routes
 */
// Go to Posts index page
$router->get('', 'Posts@index');
// Go to Posts by Category page
$router->get('category', 'Posts@category');
// Show Post Details
$router->get('post', 'Posts@show');
// Create new Post page
// $router->get('post/create', 'Posts@create'); // This is not needed because we have the form in the index page
// Edit Post page
$router->get('post/edit', 'Posts@edit');
// Delete Post page
// $router->get('post/delete', 'Posts@delete'); // This is not needed because we have the button in the Show page

//-------------------------------------------------------------------------------------------------------------//

// Store new post
$router->post('post/store', 'Posts@store');
// Update post by ID
$router->post('post/update', 'Posts@update');
// Delete post by ID
$router->post('post/destroy', 'Posts@destroy');
// Like or unlike post by ID
$router->post('post/like', 'Posts@like');
