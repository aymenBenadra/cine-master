<?php

require_once '../app/bootstrap.php';

use Core\Router;
use Core\Helpers\Request;

Router::load('../app/config/routes.php')->direct(new Request);
