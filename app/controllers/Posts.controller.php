<?php

namespace App\Controllers;

use Core\{Controller, Router};
use Exception;

class Posts extends Controller
{
    private $model;

    /**
     * Initialize Post model
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
        $posts = $this->model->getAll();

        session_start();
        $this->view('posts/index', compact('posts'));
    }

    /**
     * Go to Posts index page
     *
     * @return void
     */
    public function category($data = [])
    {
        try {
            if (empty($data) || !isset($data['cat'])) {
                throw new Exception('Posts Category is not specified');
            }
            extract($data);

            if ($cat != 1 && $cat != 2) {
                throw new Exception('Category ID is not valid');
            }

            $posts = $this->model->getAllBy("category_id", $cat);

            session_start();
            $this->view('posts/index', compact('posts', 'cat'));
        } catch (Exception $e) {
            echo $e->getMessage();
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
        try {
            if (empty($data) || !isset($data['id'])) {
                throw new Exception('Post ID is not specified');
            }

            $post = $this->model->get($data['id']);

            if (!$post) {
                throw new Exception('Post does not exist');
            } else {
                // Getting comments for this post
                $comments = $this->model('Comment')->getAllBy('post_id', $data['id']);

                if(!$comments) {
                    $comments = [];
                }

                session_start();
                $this->view('posts/show', compact('post', 'comments'));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Go to Post creation page
     *
     * @return void
     */
    public function create()
    {
        session_start();
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
        try {
            if (empty($data) || !isset($data['id'])) {
                throw new Exception('Post ID is not specified');
            }

            $post = $this->model->get($data['id']);

            if (!$post) {
                throw new Exception('Post does not exist');
            } else {
                session_start();
                $this->view('posts/edit', compact('post'));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
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
        try {
            switch (true) {
                case empty($data):
                    throw new Exception('Post data is not specified');
                case !isset($data['title']):
                    throw new Exception('Post title is not specified');
                case !isset($data['photo']):
                    throw new Exception('Post photo is not specified');
                case !isset($data['description']):
                    throw new Exception('Post description is not specified');
                case !isset($data['category_id']):
                    throw new Exception('Post category is not specified');
            }

            $data['photo'] = $this->uploadPhoto($data['photo']);

            if (!$this->model->add($data)) {
                throw new Exception('Arrgh! Something went wrong');
            } else {
                Router::redirect('/post?id=' . $this->model->getLastInsertedId());
            }
        } catch (Exception $e) {
            echo $e->getMessage();
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
        try {
            switch (true) {
                case empty($data):
                    throw new Exception('Post data is not specified');
                case !isset($data['title']):
                    throw new Exception('Post title is not specified');
                case !isset($data['photo']):
                    throw new Exception('Post photo is not specified');
                case !isset($data['description']):
                    throw new Exception('Post description is not specified');
                case !isset($data['category_id']):
                    throw new Exception('Post category is not specified');
            }

            $data['photo'] = $this->uploadPhoto($data['photo']);

            $id = $data['id'];
            unset($data['id']);

            if (!$this->model->update($id, $data)) {
                throw new Exception('Arrgh! Something went wrong');
            } else {
                Router::redirect('/post?id=' . $id);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
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
        try {
            if (empty($data) || !isset($data['id'])) {
                throw new Exception('Post ID is not specified');
            }

            if (!$this->model->delete($data['id'])) {
                throw new Exception('Arrgh! Something went wrong');
            } else {
                Router::redirect('/');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
