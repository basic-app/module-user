<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\User\Models;

use BasicApp\Behaviors\EntitySetNullBehavior;

abstract class BaseUser extends \denis303\user\User
{

    protected $modelClass = UserModel::class;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'setNull' => [
                'class' => EntitySetNullBehavior::class,
                'attributes' => [
                    'user_email'
                ]
            ]
        ]);
    }

    public function getVerificationUrl()
    {
        return UserModel::getUserVerificationUrl($this);
    }

    public function getResetPasswordUrl()
    {
        return UserModel::getUserResetPasswordUrl($this);
    }
    
}