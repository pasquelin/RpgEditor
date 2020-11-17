<?php defined('SYSPATH') OR die('No direct access allowed.');

//JS CSS
$config['admin/js_(.*).js'] = 'public/js/$1/admin';
$config['admin/css_(.*).css'] = 'public/css/$1/admin';
$config['admin/js_phpjs.js'] = 'public/php_js/admin';

$config['js_(.*).js'] = 'public/js/$1';
$config['css_(.*).css'] = 'public/css/$1';
$config['js_phpjs.js'] = 'public/php_js/';

//Article
$config['article/(.*)'] = 'article/index/$1';
$config['admin/article/(.*)'] = 'article/index/$1';
?>
