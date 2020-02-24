<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
use BasicApp\Helpers\Url;
use BasicApp\Member\MemberEvents;
use BasicApp\Admin\AdminEvents;
use BasicApp\User\Controllers\Admin\User as UserController;

if (class_exists(MemberEvents::class))
{
    MemberEvents::onAccountMenu(function($event)
    {
        $user = service('user');

        if (!$user->getUser())
        {
            $event->items['login'] = [
                'label' => t('user', 'Login'),
                'url' => Url::createUrl('user/login')
            ];

            $event->items['signup'] = [
                'label' => t('user', 'Signup'),
                'url' => Url::createUrl('user/signup')
            ];
        }
        else
        {
            $event->items['profile'] = [
                'label' => t('user', 'Edit Profile'),
                'url' => Url::createUrl('member/user/profile')
            ];

            $event->items['logout'] = [
                'label' => t('user', 'Logout'),
                'url' => Url::createUrl('logout')
            ];
        }
    });
}

if (class_exists(AdminEvents::class))
{
    AdminEvents::onMainMenu(function($event)
    {
        if (service('admin')->can(UserController::class))
        {
            $event->items['users'] = [
                'url'   => Url::createUrl('admin/user'),
                'label' => t('admin.menu', 'Users'),
                'icon'  => 'fa fa-users'
            ];
        }
    });
}