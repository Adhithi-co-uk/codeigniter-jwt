<?php

namespace Modules\Auth\Models;

use CodeIgniter\Model;


class UserRoleModel extends Model
{
    protected $table      = 'user_roles';
    protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['user_id', 'role_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dates = ['created_at', 'updated_at'];

    protected $validationRules    = [
        'user_id'     => 'required',
        'role_id'     => 'required',
    ];

    protected $validationMessages = [];
}
