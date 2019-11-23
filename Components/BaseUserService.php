<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\User\Components;

abstract class BaseUserService extends \denis303\codeigniter4\UserService
{

    const ID_SESSION = 'ba_user';

    public function findUserById($id)
    {
        $model = new $this->_modelClass;

        return $model::findByPk($id);
    }

    public function getLoginUrl()
    {
        return site_url('admin/login');
    }

    public function getLogoutUrl()
    {
        return site_url('admin/logout');
    }

}