<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\User\Forms;

use BasicApp\User\Models\UserModel;
use BasicApp\User\Models\User;

/**
 * Login form
 */
class LoginForm extends \BasicApp\Core\Model
{

    protected $returnType = 'array';

    protected static $_user;

    protected $validationRules = [
        'email' => [
            'rules' => 'required|not_special_chars|' . UserModel::EMAIL_RULES. '|' . __CLASS__ .'::validateEmail|' . __CLASS__ .'::validateVerification',
            'label' => 'Email'
        ],
        'password' => [
            'rules' => 'required|' . UserModel::PASSWORD_RULES . '|' . __CLASS__ .'::validatePassword',
            'label' => 'Password'
        ],
        'rememberMe' => [
            'rules' => 'required|in_list[0,1]',
            'label' => 'Remember Me'
        ]
    ];

    protected $validationMessages = [
        'email' => [
            __CLASS__ . '::validateEmail' => 'There is no user with this email address.',
            __CLASS__ . '::validateVerification' => 'Email is not verified.',
        ],
        'password' => [
            __CLASS__ . '::validatePassword' => 'Password Invalid.'
        ]
    ];

    /**
     * Finds user by [[user_email]]
     *
     * @return User|bool|null
     */
    public function getUser()
    {
        return static::$_user;
    }

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

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $password the attribute currently being validated
     */
    public static function validatePassword(string $password)
    {
        if (static::$_user)
        {
            return UserModel::validateUserPassword(static::$_user, $password);
        }

        return true;
    }

}