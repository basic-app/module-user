<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\User\Database\Migrations;

class CreateUserTable extends \BasicApp\Migration\BaseMigration
{

    public $table = 'user';

    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
                'unsigned' => true
            ],
            'user_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'user_email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
                'null' => true            
            ],
            'user_password_hash' => [
                'type' => 'VARCHAR',
                'constraint' => '60',
                'null' => true
            ],
            'user_created_at' => [ 
                'type' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
            ],
            'user_password_reset_token' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
                'null' => true
            ],
            'user_verification_token' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
                'null' => true
            ],
            'user_verified_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'user_enabled' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
                'default' => 1
            ]
        ]);

        $this->forge->addKey('user_id', true);

        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }

}