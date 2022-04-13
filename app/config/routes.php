<?php

/**
 * *Users Controller
 * path: app\controllers\Users.controller.php
 * 
 * - GET Routes
 * - POST Routes
 */

// Login page
$router->get('login', 'Users@login', ['Auth@guest']); // ✅
// Register page
$router->get('register', 'Users@register', ['Auth@guest']); // ✅
// Profile page
$router->get('profile', 'Users@profile', ['Auth@user']); // ✅
// Profile edit page
$router->get('profile/edit', 'Users@edit', ['Auth@user']); // ✅
// Logout page
$router->get('logout', 'Users@logout', ['Auth@user']); // ✅

// Login user and redirect to home page if success or to login page if failed with error message
$router->post('signin', 'Users@signin', ['Auth@guest', 'Validation@login|password']); // ✅
// Register user and redirect to login page if success or redirect to register page if failed with error message
$router->post('signup', 'Users@signup', ['Auth@guest', 'Validation@username|email|password|password_confirm|avatar']); // ✅
// Profile update
$router->post('profile/update', 'Users@update', ['Auth@user', 'Validation@id|username|email|avatar']); // ✅
// profile destroy
$router->post('profile/destroy', 'Users@destroy', ['Auth@user', 'Validation@id']); // ✅
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
$router->get('post/create', 'Posts@create', ['Auth@user']); // ✅
// Show Post Details
$router->get('post', 'Posts@show', ['Validation@id']); // ✅
// Edit Post page
$router->get('post/edit', 'Posts@edit', ['Auth@user', 'Validation@id']); // ✅

// Store new post
$router->post('post/store', 'Posts@store', ['Auth@user', 'Validation@title|photo|description|category_id|author_id']); // ✅
// Update post by ID
$router->post('post/update', 'Posts@update', ['Auth@user', 'Validation@id|title|photo|description|category_id|author_id']); // ✅
// Delete post by ID
$router->post('post/destroy', 'Posts@destroy', ['Auth@user', 'Validation@id']); // ✅
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
$router->post('comment/store', 'Comments@store', ['Auth@user', 'Validation@post_id|author_id|content']); // ✅
// Delete comment by ID
$router->post('comment/destroy', 'Comments@destroy', ['Auth@user', 'Validation@id']); // ✅

/**
 * *API Routes
 * path: app\controllers\Api.controller.php
 * 
 * - GET Routes
 * - POST Routes
 * - PUT Routes
 * - DELETE Routes
 */
// Api documentation page
$router->get('api', 'Api@index'); // ✅
// Get all posts
$router->get('api/posts', 'Api@posts'); // ✅
// Get post by ID
$router->get('api/post', 'Api@post', ['Validation@id']); // ✅
// Get all posts by category ID
$router->get('api/posts/category', 'Api@postsByCategory', ['Validation@cat']); // ✅
// Get all posts by user ID
$router->get('api/posts/user', 'Api@postsByUser', ['Validation@id']);

// Create new post
$router->post('api/post', 'Api@storePost', ['Validation@author_id|title|photo|description|category_id']); // ✅
// Update post by ID
$router->put('api/post', 'Api@updatePost');
// Delete post by ID
$router->delete('api/post', 'Api@destroyPost');

// Get all comments by post ID
$router->get('api/comments', 'Api@comments');
// Create new comment to post by ID
$router->post('api/comment', 'Api@storeComment');
// Delete comment by ID
$router->delete('api/comment', 'Api@destroyComment');
