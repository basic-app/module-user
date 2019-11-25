<?php

$routes->add('admin/user', 'BasicApp\User\Controllers\Admin\User::index');
$routes->add('admin/user/(:segment)', 'BasicApp\User\Controllers\Admin\User::$1');

$routes->add('member', 'BasicApp\User\Controllers\Member\User::index');
$routes->add('member/(:segment)', 'BasicApp\User\Controllers\Member\User::$1');

$routes->add('user/(:segment)', 'BasicApp\User\Controllers\User::$1');
$routes->add('user/(:segment)/(:any)', 'BasicApp\User\Controllers\User::$1/$2');