<?php

use BasicApp\Helpers\Url;
use BasicApp\System\SystemEvents;
use BasicApp\Admin\AdminEvents;

SystemEvents::onPreSystem(function()
{
    helper(['user']);
});

SystemEvents::onAccountMenu(function($event)
{
    $user = service('user');

    if ($user->isGuest())
    {
        $event->items = [
            'login' => [
                'label' => t('user', 'Login'),
                'url' => Url::createUrl('user/login')
            ],
            'signup' => [
                'label' => t('user', 'Signup'),
                'url' => Url::createUrl('user/signup')
            ]
        ];
    }
    else
    {
        $event->items = [
            'profile' => [
                'label' => t('user', 'Profile'),
                'url' => Url::createUrl('user/profile')
            ],
            'logout' => [
                'label' => t('user', 'Logout'),
                'url' => Url::createUrl('user/logout')
            ]
        ];
    }
});

AdminEvents::onMainMenu(function($event)
{
    if (BasicApp\User\Controllers\Admin\User::checkAccess())
    {
        $event->items['users'] = [
            'url'   => Url::createUrl('admin/user'),
            'label' => t('admin.menu', 'Users'),
            'icon'  => 'fa fa-users'
        ];
    }
});