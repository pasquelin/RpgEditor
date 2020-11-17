<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

$config['_default'] = 'home';

// login/logout
$config['auth'] = '/logger';
$config['login'] = '/logger/login';
$config['logout'] = '/logger/logout';
$config['send'] = '/logger/send';

//plugins
$config['actions/(.*)/(.*)'] = '/plugin_$1/$2';
$config['actions/(.*)'] = '/plugin_$1';

//js
$config['js/compile.js'] = '/home/compileJs';
?>
