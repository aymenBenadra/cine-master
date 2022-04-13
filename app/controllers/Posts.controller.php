<?php

namespace App\Controllers;

use Core\{Controller, Router};

/**
 * Posts Controller
 *
 * @author Mohammed-Aymen Benadra
 * @package App\Controllers
 */
class Posts extends Controller
{
    private $model;

    /**
     * Set the model to use
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = $this->model('Post');
    }

    /**
     * Go to Posts index page
     *
     * @return void
     */
    public function index()
    {
        $posts = $this->model->getAll() ?? [];

        // Start Session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->view('posts/index', compact('posts'));
    }

    /**
     * Go to Posts index page
     *
     * @return void
     */
    public function category($data = [])
    {
        extract($data);

        $posts = $this->model->getAllBy("category_id", $cat);

        if ($posts) {
            // Start Session
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->view('posts/index', compact('posts', 'cat'));
        } else {
            Router::redirect('/posts');
        }
    }

    /**
     * Go to Post details page
     *
     * @param  mixed $data
     * @return void
     */
    public function show($data = [])
    {
        $post = $this->model->get($data['id']);

        if (!$post) {
            Router::abort(404, 'Post not found');
        } else {
            // Getting comments for this post
            $comments = $this->model('Comment')->getAllBy('post_id', $data['id']);

            if (!$comments) {
                $comments = [];
            }

            // Start Session
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->view('posts/show', compact('post', 'comments'));
        }
    }

    /**
     * Go to Post creation page
     *
     * @return void
     */
    public function create()
    {
        // Start Session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->view('posts/create');
    }

    /**
     * Go to Post edit page
     *
     * @param  mixed $data
     * @return void
     */
    public function edit($data = [])
    {
        $post = $this->model->get($data['id']);

        if (!$post) {
            Router::abort(404, 'Post not found');
        } else {
            // Start Session
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->view('posts/edit', compact('post'));
        }
    }

    /**
     * Store new Post record in database
     *
     * @param  mixed $data
     * @return void
     */
    public function store($data = [])
    {
        $data['photo'] = $this->uploadPhoto($data['photo']);

        if (!$this->model->add($data)) {
            Router::abort(500, 'Error while creating post');
        } else {
            Router::redirect('/post?id=' . $this->model->getLastInsertedId());
        }
    }

    /**
     * Update existing Post in database
     *
     * @param  mixed $data
     * @return void
     */
    public function update($data = [])
    {

        $data['photo'] = $this->uploadPhoto($data['photo']);

        $id = $data['id'];
        unset($data['id']);

        if (!$this->model->update($id, $data)) {
            Router::abort(500, 'Error while updating post');
        } else {
            Router::redirect('/post?id=' . $id);
        }
    }

    /**
     * Destroy Post from database
     *
     * @param  mixed $data
     * @return void
     */
    public function destroy($data = [])
    {
        if (!$this->model->delete($data['id'])) {
            Router::abort(500, 'Error while deleting post');
        } else {
            Router::redirect('/');
        }
    }
}
