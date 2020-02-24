<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
$routes->add('logout', '\BasicApp\User\Controllers\Member\User::logout');

$routes->add('member/user', '\BasicApp\User\Controllers\Member\User::index');
$routes->add('member/user/(:segment)', '\BasicApp\User\Controllers\Member\User::$1');

$routes->add('admin/user', '\BasicApp\User\Controllers\Admin\User::index');
$routes->add('admin/user/(:segment)', '\BasicApp\User\Controllers\Admin\User::$1');

$routes->add('user/(:segment)', '\BasicApp\User\Controllers\User::$1');
$routes->add('user/(:segment)/(:any)', '\BasicApp\User\Controllers\User::$1/$2');