<?php

use BasicApp\Helpers\Url;
use BasicApp\System\SystemEvents;
use BasicApp\Admin\AdminEvents;
use BasicApp\User\Components\UserFilter;

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
            'member' => [
                'label' => t('user', 'My Account'),
                'url' => Url::createUrl('member')
            ],
            'profile' => [
                'label' => t('user', 'Edit Profile'),
                'url' => Url::createUrl('member/profile')
            ],
            'logout' => [
                'label' => t('user', 'Logout'),
                'url' => Url::createUrl('member/logout')
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

SystemEvents::onFilters(function($event)
{
    $event->aliases['userIsLoggedIn'] = UserFilter::class;

    $event->filters['userIsLoggedIn'] = [
        'before' => ['/member/', '/member/*']
    ];
});