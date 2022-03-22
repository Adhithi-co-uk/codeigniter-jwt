<?php

namespace Modules\Auth\Models;

use CodeIgniter\Model;


class PermissionModel extends Model
{
    protected $table      = 'permissions';
    protected $primaryKey = 'id';

    protected $returnType = \Modules\Auth\Entities\Permission::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name', 'description'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    // public $db = \Config\Database::connect();


    protected $validationRules    = [
        'name'     => 'required|alpha_numeric|min_length[3]',
        'description'     => 'required|min_length[8]',
    ];

    protected $validationMessages = [
        'name'        => [
            'alpha_numeric' => 'Please enter valid alpha numeric name.'
        ]
    ];
}
