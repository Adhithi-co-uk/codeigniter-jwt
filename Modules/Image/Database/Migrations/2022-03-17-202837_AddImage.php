<?php

namespace Modules\Image\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImage extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 255,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'unique' => true,
                'constraint' => '255',
            ],
            'thumbnail' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'medium' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'ext' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'imageable_type' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'imageable_id' => [
                'type' => 'BIGINT',
                'constraint' => 255,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('images');
    }

    public function down()
    {
        $this->forge->dropTable('images');
    }
}
