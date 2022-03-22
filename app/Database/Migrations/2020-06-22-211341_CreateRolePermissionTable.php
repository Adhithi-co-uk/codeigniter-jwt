<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolePermissionTable extends Migration
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
			'role_id'       => [
				'type'           => 'INT',
			],
			'permission_id'       => [
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
		$this->forge->createTable('role_permissions');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('role_permission');
	}
}
