<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 */
namespace BasicApp\User\Models\Admin;

abstract class BaseUserModel extends \BasicApp\User\Models\UserModel
{

    protected $returnType = User::class;

    protected $allowedFields = [
        'user_email',
        'user_name',
        'user_enabled',
        'user_password_hash'
    ];

    protected $validationRules = [
        'user_email' => self::EMAIL_RULES . '|not_special_chars|permit_empty',
        'user_name' => 'max_length[255]|not_special_chars',
        'user_enabled' => 'in_list[0,1]',
        'user_password' => self::PASSWORD_RULES . '|permit_empty'
    ];

}