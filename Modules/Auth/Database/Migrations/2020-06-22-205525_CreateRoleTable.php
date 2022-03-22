<?php

namespace Modules\Auth\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoleTable extends Migration
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
			'name'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
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
		$this->forge->createTable('roles');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('roles');
	}
}
