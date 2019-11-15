<?php

namespace BasicApp\User\Forms;

use Config\Services;
use BasicApp\User\Models\UserModel;

/**
 * Signup form
 */
class SignupForm extends \BasicApp\Core\Model
{

    protected $returnType = 'array';

    protected $validationRules = [
        'username' => [
            'rules' => 'required|max_length[255]|min_length[2]',
            'label' => 'Name',
        ],
        'email' => [
            'rules' => 'required|' . UserModel::EMAIL_RULES . '|is_unique[user.user_email,user_id,{user_id}]',
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
        $message = view('messages/signup', [
            'user' => $user,
            'verifyLink' => UserModel::getUserVerificationUrl($user)
        ]);

        $mailer = service('mailer');

        return $mailer->sendToUser(
            $user, 
            'Account registration at ' . base_url(), 
            $message,
            [], 
            $error
        );
    }

}