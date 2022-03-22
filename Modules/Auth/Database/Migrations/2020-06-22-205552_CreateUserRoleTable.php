<?php

namespace Modules\Auth\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserRoleTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],
			'user_id'       => [
				'type'           => 'INT',
			],
			'roleid'       => [
				'type'           => 'INT',
			],
			'created_at'       => [
				'type'           => 'DATETIME',
			],
			'updated_at'       => [
				'type'           => 'DATETIME',
				'null'           => TRUE,
			],
			'description'       => [
				'type'           => 'TEXT',
				'null'           => TRUE,
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('user_roles');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('user_roles');
	}
}
