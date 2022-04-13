<?php

namespace App\Controllers;

use Core\{Controller, Router};
use Core\Helpers\Request;
use Exception;

/**
 * Api Controller
 *
 * @author Mohammed-Aymen Benadra
 * @package App\Controllers
 */
class Api extends Controller
{
    /**
     * Set headers for JSON response
     *
     * @return void
     */
    public function __construct()
    {
        // Set basic headers for JSON response
        header('Content-Type: application/json; charset=UTF-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

        // set response code
        Request::setResponseCode(200);
    }

    /**
     * Show Api documentation
     * 
     * @return void
     */
    public function index()
    {
        // Set content type
        header('Content-Type: text/html; charset=UTF-8');
        // Render Api documentation
        $this->view('api/index');
    }

    /**
     * Get all posts
     *
     * @return void
     */
    public function posts()
    {
        $posts = $this->model('Post')->getAll();

        if (!$posts) {
            Router::abort(404, json_encode([
                'status' => 'error',
                'message' => 'No posts not found'
            ]));
        }

        exit(json_encode([
            'status' => 'success',
            'data' => $posts,
            'count' => count($posts)
        ]));
    }
    /**
     * Get post by ID
     *
     * @return void
     */
    public function post($data = [])
    {
        $post = $this->model('Post')->get($data['id']);

        if (!$post) {
            Router::abort(404, json_encode([
                'status' => 'error',
                'message' => 'Post not found'
            ]));
        }

        exit(json_encode([
            'status' => 'success',
            'data' => $post
        ]));
    }
    /**
     * Get all posts by category ID
     *
     * @return void
     */
    public function postsByCategory($data = [])
    {
        $posts = $this->model('Post')->getAllBy("category_id", $data['id']);

        if (!$posts) {
            Router::abort(404, json_encode([
                'status' => 'error',
                'message' => 'No posts found'
            ]));
        }

        exit(json_encode([
            'status' => 'success',
            'data' => $posts,
            'count' => count($posts)
        ]));
    }

    /**
     * Get all posts by user ID
     *
     * @return void
     */
    public function postsByUser($data = [])
    {
        $user = $this->model('User')->get($data['id']);

        if (!$user) {
            Router::abort(404, json_encode([
                'status' => 'error',
                'message' => 'User not found'
            ]));
        }

        $posts = $this->model('Post')->getAllBy("author_id", $data['id']);

        if (!$posts) {
            Router::abort(404, json_encode([
                'status' => 'error',
                'message' => 'No posts found'
            ]));
        }

        exit(json_encode([
            'status' => 'success',
            'data' => $posts,
            'count' => count($posts)
        ]));
    }

    /**
     * Create a new post
     * 
     * @param  mixed $data
     * @return void
     */
    public function storePost($data = [])
    {
        $user = $this->model('User')->get($data['author_id']);
        
        if (!$user) {
            Router::abort(404, json_encode([
                'status' => 'error',
                'message' => 'User not found'
            ]));
        }
        
        $data['photo'] = $this->uploadPhoto(
            $data['photo']
        );
        
        $post = $this->model('Post')->add($data);

        if (!$post) {
            Router::abort(500, json_encode([
                'status' => 'error',
                'message' => 'An error occured'
            ]));
        }

        $post = $this->model('Post')->get(
            $this->model('Post')->getLastInsertedId()
        );

        exit(json_encode([
            'status' => 'success',
            'data' => $post
        ]));
    }

    /**
     * Update a post
     * 
     * @return void
     */
    public function updatePost($data = [])
    {
        try {
            if (empty($data) || !isset($data['id']) || !isset($data['title']) || !isset($data['content']) || !isset($data['category_id']) || !isset($data['author_id'])) {
                throw new Exception('Title, content, category_id and author_id are required', 400);
            }
            extract($data);

            $post = $this->model('Post')->update($id, [
                'title' => $title,
                'content' => $content,
                'category_id' => $category_id,
                'author_id' => $author_id
            ]);

            if ($post === false) {
                throw new Exception('Database error');
            }

            exit(json_encode([
                'status' => 'success',
                'data' => $post
            ]));
        } catch (Exception $e) {
            // set response code
            Request::setResponseCode($e->getCode() ?? 500);

            exit(json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]));
        }
    }
}
