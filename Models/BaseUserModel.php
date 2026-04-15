<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\User\Models;

use BasicApp\Core\Model;

abstract class BaseUserModel extends Model
{
    const EMAIL_RULES = 'max_length[255]|valid_email|min_length[2]';
    const PASSWORD_RULES = 'max_length[72]|min_length[5]';

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $returnType = User::class;

    protected $fieldLabels = [
        'user_id' => 'ID',
        'user_created_at' => 'Created',
        'user_email' => 'Email',
        'user_name' => 'Name',
        'user_enabled' => 'Enabled',
        'user_password' => 'Password',
        'user_verification_token' => 'Verification Token',
        'user_password_reset_token' => 'Password Reset Token'
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

   public static function createUser(array $data, &$error = null)
    {
        $modelClass = get_called_class();

        $model = new $modelClass;

        $class = $model->returnType;

        $user = new $class;

        if (array_key_exists('user_password', $data))
        {
            static::setUserPassword($user, $data['user_password']);

            unset($data['user_password']);
        }

        foreach($data as $key => $value)
        {
            $user->$key = trim(strip_tags($value));
        }

        $model->beforeCreateUser($user, $data);

        $model->protect(false);

        if (!$model->save($user))
        {
            $errors = $model->errors();

            if ($errors)
            {
                $error = array_shift($errors);
            }
            else
            {
                $error = 'Unknown error.';
            }

            return false;
        }

        $id = $model->getInsertID();

        $model = new $modelClass;

        return $model->find($id);
    }

    public static function setUserPassword($user, string $password)
    {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
    
        static::setUserField($user, 'password_hash', $password_hash);
    }

    public static function setUserField($user, string $field, $value, bool $applyPrefix = true)
    {
        if ($applyPrefix)
        {
            $field = 'user_' . $field;
        }

        if (is_array($user))
        {
            $user[$field] = $value;
        }
        else
        {
            $user->$field = $value;
        }
    }

    public static function getUserEmail($user)
    {
        return static::getUserField($user, 'email', true);
    }

    public static function getUserName($user)
    {
        return static::getUserField($user, 'name', true);
    }

    public static function validateUserPassword($user, string $password) : bool
    {
        $password_hash = static::getUserField($user, 'password_hash');

        return password_verify($password, $password_hash);
    }

    public static function getUserField($user, string $field, bool $applyPrefix = true)
    {
        if ($applyPrefix)
        {
            $field = 'user_' . $field;
        }

        if (is_array($user))
        {
            return $user[$field];
        }
        else
        {
            return $user->$field;
        }
    }

    public static function findByEmail($email)
    {
        $class = get_called_class();

        $model = new $class;

        return $model->where(['user_email' => $email])->first();
    }
}