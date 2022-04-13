<?php

namespace App\Controllers;

use Core\{Controller, Router};

/**
 * Comments Controller
 *
 * @author Mohammed-Aymen Benadra
 * @package App\Controllers
 */
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
        if (!$this->model->add($data)) {
            Router::abort(500, 'Error while saving comment');
        } else {
            Router::redirect('/post?id=' . $data['post_id']);
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
            Router::abort(500, 'Error while deleting comment');
        } else {
            Router::redirect('/post?id=' . $data['post_id']);
        }
    }
}
