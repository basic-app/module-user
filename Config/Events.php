<?php

use BasicApp\Helpers\Url;
use BasicApp\System\SystemEvents;
use BasicApp\Admin\AdminEvents;

SystemEvents::onPreSystem(function()
{
    helper(['user']);
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