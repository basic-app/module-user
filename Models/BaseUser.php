<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 */
namespace BasicApp\User\Models;

abstract class BaseUser extends \denis303\user\User
{

    protected $modelClass = UserModel::class;

    public function getVerificationUrl()
    {
        return UserModel::getUserVerificationUrl($this);
    }

    public function getResetPasswordUrl()
    {
        return UserModel::getUserResetPasswordUrl($this);
    }
    
}