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
 * Password reset form
 */
class ResetPasswordForm extends \BasicApp\Core\Model
{

    protected $returnType = 'array';

    protected $validationRules = [
        'password' => [
            'rules' => 'required|not_special_chars|' . UserModel::PASSWORD_RULES,
            'label' => 'Password'
        ]
    ];

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword($user, $data, &$error)
    {
        UserModel::setUserPassword($user, $data['password']);

        UserModel::setUserField($user, 'password_reset_token', null);

        return UserModel::saveEntity($user, false, $error);
    }

}