<?php

namespace App\Database\Migrations;

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
			'role_id'       => [
				'type'           => 'INT',
			],
			'created_at'       => [
				'type'           => 'DATETIME',
			],
			'created_by'       => [
				'type'           => 'INT',
				'null'           => TRUE,
			],
			'updated_at'       => [
				'type'           => 'DATETIME',
				'null'           => TRUE,
			],
			'updated_by'       => [
				'type'           => 'INT',
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
