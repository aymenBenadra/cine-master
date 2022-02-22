<?php

require_once '../app/bootstrap.php';

use Core\{Router, App};
use Core\Helpers\Request;

App::bind("Router", Router::load('../app/config/routes.php'));

App::get("Router")->direct(Request::uri(), Request::method(), Request::data());
