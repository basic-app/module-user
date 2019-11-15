<?php

$routes->add('admin/user', 'BasicApp\User\Controllers\Admin\User::index');
$routes->add('admin/user/(:segment)', 'BasicApp\User\Controllers\Admin\User::$1');

$routes->add('user', 'BasicApp\User\Controllers\User::index');
$routes->add('user/(:segment)', 'BasicApp\User\Controllers\User::$1');