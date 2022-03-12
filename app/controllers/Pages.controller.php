<?php

namespace App\Controllers;

use Core\Controller;
use Core\Helpers\Request;

/**
 * Pages Controller
 *
 * @author Mohammed-Aymen Benadra
 * @package App\Controllers
 */
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
