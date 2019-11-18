<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 */
namespace BasicApp\User\Models;

abstract class BaseUserModel extends \denis303\user\UserModel
{

    const EMAIL_RULES = 'max_length[255]|valid_email|min_length[2]';

    const PASSWORD_RULES = 'max_length[72]|min_length[5]';

    protected $returnType = User::class;

    protected $fieldLabels = [
        self::FIELD_PREFIX . 'id' => 'ID',
        self::FIELD_PREFIX  . 'created_at' => 'Created',
        self::FIELD_PREFIX . 'email' => 'Email',
        self::FIELD_PREFIX . 'name' => 'Name',
        self::FIELD_PREFIX . 'enabled' => 'Enabled',
        self::FIELD_PREFIX . 'password' => 'Password'
    ];

    public function beforeCreateUser($user, array $data)
    {
        $token = static::getUserField($user, 'verification_token');

        if (!$token)
        {
            static::setUserField($user, 'verification_token', static::generateToken());
        }
    }

    public static function generateToken()
    {
        return md5(time() . rand(0, PHP_INT_MAX)) . '_' . time();
    }

    public static function getUserVerificationUrl($user)
    {
        $id = static::getUserField($user, 'id');

        $token = static::getUserField($user, 'verification_token');

        return site_url('user/verifyEmail/' . $id  . '/'. $token);
    }

    public static function getUserResetPasswordUrl($user)
    {
        $id = static::getUserField($user, 'id');
        
        $token = static::getUserField($user, 'password_reset_token');

        return site_url('user/resetPassword/' . $id . '/' .  $token);
    }

    /**
     * Finds out if token is valid
     *
     * @param string $token token
     * @return bool
     */
    public static function isTokenValid($token)
    {
        if (!$token)
        {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
     
        $expire = 600;
        
        return $timestamp + $expire >= time();
    }

    public static function setUserVerification($user, $token, &$error = null)
    {
        if (static::getUserField($user, 'verified_at'))
        {
            $error = 'User already verified.';

            return false;
        }

        if (static::getUserField($user, 'verification_token') != $token)
        {
            $error = 'Unable to verify your account with provided token.';
        
            return false;
        }

        $model = new UserModel;

        $model->set('user_verified_at', 'NOW()', false);

        $model->set('user_verification_token', 'NULL', false);

        $model->protect(false);

        $id = $model::getUserField($user, 'id');

        $updated = $model->update($id);

        $model->protect(true);

        if (!$updated)
        {
            $error = $model->getFirstError();

            return false;
        }

        $user = UserModel::findByPk($id);

        return true;
    }

}