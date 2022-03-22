<?php
namespace Modules\Auth\Models;
use CodeIgniter\Model;


class RoleModel extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id';

    protected $returnType = \Modules\Auth\Entities\Role::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name', 'description'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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