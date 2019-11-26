<?php

namespace BasicApp\User\Forms;

use Config\Services;
use BasicApp\User\Models\User;
use BasicApp\User\Models\UserModel;
use BasicApp\Message\Models\MessageModel;

/**
 * Signup form
 */
class SignupForm extends \BasicApp\Core\Model
{

    protected $returnType = 'array';

    protected $validationRules = [
        'username' => [
            'rules' => 'required|not_special_chars|max_length[255]|min_length[2]',
            'label' => 'Name',
        ],
        'email' => [
            'rules' => 'required|not_special_chars|' . UserModel::EMAIL_RULES . '|is_unique[user.user_email,user_id,{user_id}]',
            'label' => 'Email',
        ],
        'password' => [
            'rules' => 'required|' . UserModel::PASSWORD_RULES,
            'label' => 'Password'
        ]
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email address has already been taken.'
        ]
    ];

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup(array $data, &$error = null)
    {
        $model = new UserModel;
        
        return $model->createUser([
            'user_name' => $data['username'],
            'user_email' => $data['email'],
            'user_password' => $data['password']
        ], $error);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user data to with email should be send
     * @return bool whether the email was sent
     */
    public function sendEmail(User $user, &$error = null)
    {
        $params = [
            '{verifyLink}' => UserModel::getUserVerificationUrl($user)
        ];

        return MessageModel::getMessage('signup', true, [
            'message_subject' => 'Account registration at {base_url}',
            'message_body' => '{verifyLink}'
        ])->sendToUser($user, $params, $error);
    }

}