<?php

namespace Modules\Auth\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \Modules\Auth\Entities\User::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'email', 'password'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name' => [
            'rules' => 'required|min_length[3]'
        ],
        'email' => [
            'rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[users.email]'
        ],
        'password' => [
            'rules' => 'required|min_length[8]|max_length[255]'
        ],
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function search_list($search, $limit, $offset)
    {
        $builder = $this->db->table('users');
        if (is_numeric($search)) {
            $builder->where('id', $search);
        } else {
            $builder->like('users.name', $search, 'both');
            $builder->orLike('email', $search, 'both');
        }
        $builder->join('images', 'images.imageable_id=users.id', 'left');
        $builder->select('users.id,users.name,users.email,images.thumbnail,images.uri_path');
        $builder->limit($limit, $offset);
        $query = $builder->get();
        return  $query->getResult();
    }
}
