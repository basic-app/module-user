<?php

namespace BasicApp\User\Forms;

use Exception;
use BasicApp\User\Models\UserModel;
use BasicApp\User\Models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends \BasicApp\Core\Model
{

    protected $returnType = 'array';

    protected static $_user;

    protected $validationRules = [
        'email' => [
            'rules' => 'required|' . UserModel::EMAIL_RULES . '|' . __CLASS__ . '::validateEmail|' .  __CLASS__ .'::validateVerification',
            'label' => 'Email'
        ]
    ];

    protected $validationMessages = [
        'email' => [
            __CLASS__ . '::validateEmail' => 'There is no user with this email address.',
            __CLASS__ . '::validateVerification' => 'Unable to reset password for not verified email address.'
        ]
    ];

    public static function validateEmail($email)
    {
        static::$_user = UserModel::findByEmail($email);

        return static::$_user ? true : false;
    }

    public static function validateVerification($email)
    {
        if (static::$_user)
        {
            if (!UserModel::getUserField(static::$_user, 'verified_at'))
            {
                static::$_user = null;

                return false;
            }
        }

        return true;
    }    

    public function getUser()
    {
        return static::$_user;
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail(&$error = null)
    {    
        $user = $this->getUser();

        if (!UserModel::isTokenValid(UserModel::getUserField($user, 'password_reset_token')))
        {
            UserModel::setUserField($user, 'password_reset_token', UserModel::generateToken());

            if (!UserModel::saveUser($user, $error))
            {
                throw new Exception($error);
            }
        }

        return service('mailer')->sendToUser(
            $user,
            'Password reset for ' . base_url(),
            view('messages/resetPassword', [
                'user' => $user,
                'resetLink' => UserModel::getUserResetPasswordUrl($user)
            ]),
            [],
            $error
        );
    }

}