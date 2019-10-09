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

        $return[static::FIELD_PREFIX . 'enabled'] = [
            'type' => 'TINYINT',
            'constraint' => 1,
            'null' => false,
            'default' => 1
        ];

        return $return;
    }

}