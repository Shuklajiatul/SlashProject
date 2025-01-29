<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'unsigned' => true, // It's a good practice to specify unsigned for auto-increment fields
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id', true); // Change 'Xid' to 'id'
        $this->forge->createTable('roles');

        // Insert initial values
        $this->db->table('roles')->insertBatch([
            ['id' => 1, 'role' => 'admin'],
            ['id' => 2, 'role' => 'supervisor'],
            ['id' => 3, 'role' => 'team leader'],
            ['id' => 4, 'role' => 'agent'],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('roles');
    }
}