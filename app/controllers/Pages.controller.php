<?php

namespace App\Controllers;

use Core\Controller;
use Core\Helpers\Request;

class Pages extends Controller
{    
    /**
     * Page not found
     * 
     * @return void
     */
    public function notFound()
    {
        Request::setResponseCode(404);
        $this->view('pages/404');
    }
}
