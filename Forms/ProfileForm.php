<?php

namespace BasicApp\User\Forms;

use BasicApp\User\Models\UserModel;

class ProfileForm extends UserModel
{

    protected $_user;

    protected $returnType = 'array';

    protected $validationRules = [
        'user_name' => [
            'rules' => 'required|not_special_chars|max_length[255]|min_length[2]',
            'label' => 'Name',
        ],
        'password' => [
            'rules' =>  'permit_empty|' .  UserModel::PASSWORD_RULES,
            'label' => 'Password'
        ]
    ];

    protected $allowedFields = ['user_name', 'user_password_hash'];

    public function saveProfile($data, &$error = null)
    {
        if (!empty($data->password))
        {
            static::setUserPassword($data, $data->password);
        }
        
        return $this->save($data);
    }

}