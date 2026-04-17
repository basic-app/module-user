<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */

$routes->add('login', '\BasicApp\User\Controllers\User::login');
$routes->add('signup', '\BasicApp\User\Controllers\User::signup');

$routes->add('admin/user', '\BasicApp\User\Controllers\Admin\User::index');
$routes->add('admin/user/(:segment)', '\BasicApp\User\Controllers\Admin\User::$1');

$routes->add('member/profile', '\BasicApp\User\Controllers\Member\Profile::index');
$routes->add('member/logout', '\BasicApp\User\Controllers\Member\Logout::index');

$routes->add('user/(:segment)', '\BasicApp\User\Controllers\User::$1');
$routes->add('user/(:segment)/(:any)', '\BasicApp\User\Controllers\User::$1/$2');