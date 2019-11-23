<?php

namespace BasicApp\User\Forms;

use BasicApp\User\Models\UserModel;

class ProfileForm extends UserModel
{

    protected $_user;

    protected $returnType = 'array';

    protected $validationRules = [
        'user_name' => [
            'rules' => 'required|max_length[255]|min_length[2]',
            'label' => 'Name',
        ],
        'password' => [
            'rules' =>  'permit_empty|' .  UserModel::PASSWORD_RULES,
            'label' => 'Password'
        ]
    ];

    protected $allowedFields = ['user_name', 'user_password_hash'];

    public function __construct($user)
    {
        parent::__construct();
    
        $this->_user = $user;
    }

    public function saveProfile($data, &$error = null)
    {
        foreach($this->allowedFields as $field)
        {
            if (array_key_exists($field, $data))
            {
                $this->_user->$field = $data[$field];
            }
        }

        if (!empty($data['password']))
        {
            static::setUserPassword($this->_user, $data['password']);
        }
        
        return $this->save($this->_user);
    }

}