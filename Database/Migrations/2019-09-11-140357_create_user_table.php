<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 */
namespace BasicApp\User\Database\Migrations;

class CreateUserTable extends \denis303\user\CreateUserTableMigration
{

    public function getFields()
    {
        $return = parent::getFields();

        $return[static::FIELD_PREFIX . 'password_reset_token'] = [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'unique' => true,
            'null' => true
        ];

        $return[static::FIELD_PREFIX . 'verification_token'] = [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'unique' => true,
            'null' => true
        ];

        $return[static::FIELD_PREFIX . 'verified_at'] = [
            'type' => 'DATETIME',
            'null' => true
        ];

        $return[static::FIELD_PREFIX . 'enabled'] = [
            'type' => 'TINYINT',
            'constraint' => 1,
            'null' => false,
            'default' => 1
        ];

        return $return;
    }

}