<?php

// DB Params
// mysql://ba41d251d245a8:a56e4538@us-cdbr-east-05.cleardb.net/heroku_4c98996cdaefcf0?reconnect=true
define('DB_HOST', 'us-cdbr-east-05.cleardb.net');
define('DB_USER', 'ba41d251d245a8');
define('DB_PASS', 'a56e4538');
define('DB_NAME', 'cine-master');

// App Root
define('APPROOT', dirname(__DIR__));

// Core Root
define('COREROOT', dirname(APPROOT).'/core');

// Public Root
define('PUBROOT', dirname(APPROOT).'/public');

// URL Link Root
define('URLROOT', 'https://cine-master.herokuapp.com/');

// Site Name
define('SITENAME', 'Cine Master');
