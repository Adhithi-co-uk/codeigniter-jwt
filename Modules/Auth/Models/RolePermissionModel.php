<?php

namespace Modules\Auth\Models;

use CodeIgniter\Model;


class RolePermissionModel extends Model
{
    protected $table      = 'role_permissions';
    protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'role_id', 'permission_id'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    // public $db = \Config\Database::connect();

}
