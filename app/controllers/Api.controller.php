<?php

namespace App\Controllers;

use Core\Controller;
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
        try {
            $posts = $this->model('Post')->getAll() ?? [];
            echo json_encode([
                'status' => 'success',
                'data' => $posts,
                'count' => count($posts)
            ]);
        } catch (Exception $e) {
            // set response code
            Request::setResponseCode($e->getCode() ?? 500);

            // exit(json_encode([
            //     'status' => 'error',
            //     'message' => $e->getMessage()
            // ]));
            // die(json_encode([
            //     'status' => 'error',
            //     'message' => $e->getMessage()
            // ]));
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    /**
     * Get post by ID
     *
     * @return void
     */
    public function post($data = [])
    {
        try {
            if (empty($data) || !isset($data['id'])) {
                throw new Exception('Post ID is not specified', 400);
            }
            extract($data);
            $post = $this->model('Post')->get($id);

            if (!$post) {
                throw new Exception('Post not found', 404);
            }

            echo json_encode([
                'status' => 'success',
                'data' => $post
            ]);
        } catch (Exception $e) {
            // set response code
            Request::setResponseCode($e->getCode() ?? 500);

            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    /**
     * Get all posts by category ID
     *
     * @return void
     */
    public function postsByCategory($data = [])
    {
        try {
            if (empty($data) || !isset($data['id'])) {
                throw new Exception('Category ID is not specified', 400);
            }
            extract($data);

            if ($id != 1 && $id != 2) {
                throw new Exception('Category ID is not valid', 400);
            }

            $posts = $this->model('Post')->getAllBy("category_id", $id);

            echo json_encode([
                'status' => 'success',
                'data' => $posts,
                'count' => count($posts)
            ]);
        } catch (Exception $e) {
            // set response code
            Request::setResponseCode($e->getCode() ?? 500);

            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    /**
     * Get all posts by user ID
     *
     * @return void
     */
    public function postsByUser($data = [])
    {
        try {
            if (empty($data) || !isset($data['id'])) {
                throw new Exception('User ID is not specified');
            }

            extract($data);

            $user = $this->model('User')->get($id);

            if (!$user) {
                throw new Exception('User not found', 404);
            }

            $posts = $this->model('Post')->getAllBy("author_id", $id);

            if ($posts === false) {
                throw new Exception('Database error');
            }

            echo json_encode([
                'status' => 'success',
                'data' => $posts,
                'count' => count($posts)
            ]);
        } catch (Exception $e) {
            // set response code
            Request::setResponseCode($e->getCode() ?? 500);

            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Create a new post
     * 
     * @return void
     */
    public function createPost($data = [])
    {
        try {
            if (empty($data) || !isset($data['title']) || !isset($data['content']) || !isset($data['category_id']) || !isset($data['author_id'])) {
                throw new Exception('Title, content, category_id and author_id are required', 400);
            }
            extract($data);

            $post = $this->model('Post')->create([
                'title' => $title,
                'content' => $content,
                'category_id' => $category_id,
                'author_id' => $author_id
            ]);

            if ($post === false) {
                throw new Exception('Database error');
            }

            echo json_encode([
                'status' => 'success',
                'data' => $post
            ]);
        } catch (Exception $e) {
            // set response code
            Request::setResponseCode($e->getCode() ?? 500);

            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
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

            echo json_encode([
                'status' => 'success',
                'data' => $post
            ]);
        } catch (Exception $e) {
            // set response code
            Request::setResponseCode($e->getCode() ?? 500);

            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
