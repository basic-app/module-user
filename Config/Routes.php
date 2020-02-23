<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
 
$routes->add('admin/user', '\BasicApp\User\Controllers\Admin\User::index');
$routes->add('admin/user/(:segment)', '\BasicApp\User\Controllers\Admin\User::$1');

$routes->add('user/(:segment)', '\BasicApp\User\Controllers\User::$1');
$routes->add('user/(:segment)/(:any)', '\BasicApp\User\Controllers\User::$1/$2');