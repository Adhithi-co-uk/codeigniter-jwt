<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Modules\Auth\Entities\User;
use Modules\Auth\Models\UserModel;

class AuthData extends Seeder
{
    public function run()
    {
        $data = [
            'name' => 'Nish',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'email'    => 'test@admin.com',
            'is_super_admin' => true
        ];

        // Simple Queries
        // $this->db->query("INSERT INTO users (name,email,password) VALUES(:name:,:email:, :password:)", $data);

        // Using Query Builder
        $this->db->table('users')->insert($data);

        $userId = $this->db->insertID();


        $data = [
            'name' => 'Admin',
        ];

        // Simple Queries
        // $this->db->query("INSERT INTO users (name,email,password) VALUES(:name:,:email:, :password:)", $data);

        // Using Query Builder
        $this->db->table('roles')->insert($data);

        $roleId = $this->db->insertID();


        $data = [
            'role_id' => $roleId,
            'user_id' => $userId
        ];

        // Simple Queries
        // $this->db->query("INSERT INTO users (name,email,password) VALUES(:name:,:email:, :password:)", $data);

        // Using Query Builder
        $this->db->table('user_roles')->insert($data);

        $user_role_id = $this->db->insertID();
    }
}
