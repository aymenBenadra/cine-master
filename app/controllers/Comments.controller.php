<?php

namespace App\Controllers;

use Core\{Controller, Router};
use Exception;

class Comments extends Controller
{
    private $model;

    /**
     * Initialize Post model
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = $this->model('Comment');
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
                case !isset($data['post_id']):
                    throw new Exception('Post ID is not specified');
                case !isset($data['author_id']):
                    throw new Exception('Author ID is not specified');
                case !isset($data['content']):
                    throw new Exception('Comment content is not specified');
            }

            if (!$this->model->add($data)) {
                throw new Exception('Arrgh! Something went wrong');
            } else {
                Router::redirect('/post?id=' . $data['post_id']);
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
            if (empty($data)){
                if(!isset($data['id'])) {
                throw new Exception('Comment ID is not specified');
                }
                else if(!isset($data['post_id'])) {
                throw new Exception('Post ID is not specified');
                }
            }

            if (!$this->model->delete($data['id'])) {
                throw new Exception('Arrgh! Something went wrong');
            } else {
                Router::redirect('/post?id=' . $data['post_id']);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
