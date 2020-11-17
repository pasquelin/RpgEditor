<?php

 defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

 $config['_default'] = 'home';

// login/logout
 $config['auth'] = '/logger/auth';
 $config['login'] = '/logger/login';
 $config['logout'] = '/logger/logout';

// gestion de la pagination
 $config['regions/child/([0-9]+)'] = 'regions/index/$1';
?>
