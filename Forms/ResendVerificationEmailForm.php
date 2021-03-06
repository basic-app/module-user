<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\User\Forms;

use Exception;
use BasicApp\Message\Models\MessageModel;
use BasicApp\User\Models\UserModel;
use BasicApp\User\Models\User;

class ResendVerificationEmailForm extends \BasicApp\Core\Model
{

    protected $returnType = 'array';

    protected static $_user;

    protected $validationRules = [
        'email' => [
            'label' => 'Email',
            'rules' => 'required|not_special_chars|' . UserModel::EMAIL_RULES . '|' . __CLASS__ . '::validateEmail|' . __CLASS__ . '::validateVerification'
        ]
    ];

    protected $validationMessages = [
        'email' => [
            __CLASS__ . '::validateEmail' => 'There is no user with this email address.',
            __CLASS__ . '::validateVerification' => 'Email is already verified.'
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
            if (UserModel::getUserField(static::$_user, 'verified_at'))
            {
                return false;
            }
        }

        return true;
    }

    public function getUser()
    {
        return static::$_user;
    }

    public function sendEmail(&$error)
    {
        $user = $this->getUser();

        if (!UserModel::isTokenValid(UserModel::getUserField($user, 'verification_token')))
        {
            UserModel::setUserField($user, 'verification_token', UserModel::generateToken());

            if (!UserModel::saveEntity($user, false, $error))
            {
                throw new Exception($error);
            }
        }

        $params = [
            '{verifyLink}' => UserModel::getUserVerificationUrl($user)
        ];

        return MessageModel::getMessage('email-verification', true, [
            'message_subject' => 'Account verification at {base_url}',
            'message_body' => '{verifyLink}'
        ])->sendToUser($user, $params, $error);
    }

}