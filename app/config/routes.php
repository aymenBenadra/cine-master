<?php

/**
 * *Users Controller
 * path: app\controllers\Users.controller.php
 * 
 * - GET Routes
 * - POST Routes
 */
// Login page
$router->get('login', 'Users@login'); // ✅
// Register page
$router->get('register', 'Users@register'); // ✅
// Profile page
$router->get('profile', 'Users@profile'); // ✅
// Profile edit page
$router->get('profile/edit', 'Users@edit'); // ✅
// Logout page
$router->get('logout', 'Users@logout'); // ✅

// Login user and redirect to home page if success or to login page if failed with error message
$router->post('signin', 'Users@signin'); // ✅
// Register user and redirect to login page if success or redirect to register page if failed with error message
$router->post('signup', 'Users@signup'); // ✅
// Profile update
$router->post('profile/update', 'Users@update'); // ✅
// profile destroy
$router->post('profile/destroy', 'Users@destroy'); // ✅
/**
 * *Posts Controller
 * path: app\controllers\Posts.controller.php
 * 
 * - GET Routes
 * - POST Routes
 */
// Go to Posts index page
$router->get('', 'Posts@index'); // ✅
// Go to Posts by Category page
$router->get('category', 'Posts@category'); // ✅
// Create new Post page
$router->get('post/create', 'Posts@create'); // ✅
// Show Post Details
$router->get('post', 'Posts@show'); // ✅
// Edit Post page
$router->get('post/edit', 'Posts@edit'); // ✅

// Store new post
$router->post('post/store', 'Posts@store'); // ✅
// Update post by ID
$router->post('post/update', 'Posts@update'); // ✅
// Delete post by ID
$router->post('post/destroy', 'Posts@destroy'); // ✅
// Like or unlike post by ID
// $router->post('post/like', 'Posts@like');


/**
 * *Comments Controller
 * path: app\controllers\Comments.controller.php
 * 
 * - GET Routes
 * - POST Routes
 */

 // Add comment to post by ID
$router->post('comment/store', 'Comments@store'); // ✅
// Delete comment by ID
$router->post('comment/destroy', 'Comments@destroy'); // ✅