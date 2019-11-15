<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\User\Config;

use Exception;
use Config\App as AppConfig;
use BasicApp\User\Components\UserService;
use BasicApp\User\Models\UserModel;

abstract class BaseServices extends \CodeIgniter\Config\BaseService
{

    public static function user($getShared = true)
    {
        if (!$getShared)
        {
            $session = service('session');

            $appConfig = config(AppConfig::class);

            $userService = new UserService(UserModel::class, $session, $appConfig);

            return $userService;
        }

        return static::getSharedInstance(__FUNCTION__);
    }

}