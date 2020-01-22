<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
use BasicApp\Helpers\Url;
use BasicApp\Site\SiteEvents;
use BasicApp\Admin\AdminEvents;
use BasicApp\User\Controllers\Admin\User as UserController;

if (class_exists(SiteEvents::class))
{
    SiteEvents::onAccountMenu(function($event)
    {
        $user = service('user');

        if (!$user->getUser())
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
}

if (class_exists(AdminEvents::class))
{
    AdminEvents::onMainMenu(function($event)
    {
        if (UserController::checkAccess())
        {
            $event->items['users'] = [
                'url'   => Url::createUrl('admin/user'),
                'label' => t('admin.menu', 'Users'),
                'icon'  => 'fa fa-users'
            ];
        }
    });
}