<?php

namespace Modules\Auth\Entities;

use CodeIgniter\Entity\Entity;
use Modules\Auth\Models\RoleModel;
use Modules\Auth\Models\RolePermissionModel;
use Modules\Auth\Models\UserRoleModel;
use Modules\Image\Models\ImageModel;

class User extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
    protected $attributes = [
        'id'         => null,
        'name'       => null,
        'email'      => null,
        'roles'      => null,
        'password'   => null,
        'created_at' => null,
        'updated_at' => null,
    ];

    protected function getRole_Ids()
    {
        if (isset($this->attributes['role_ids'])) {
            return $this->attributes['role_ids'];
        }
        $this->attributes['role_ids'] = [];
        $userRoleModel = new UserRoleModel();
        $user_roles = $userRoleModel->where('user_id', $this->id)->select('role_id')->findAll();
        foreach ($user_roles as $role) {
            array_push($this->attributes['role_ids'], $role->role_id);
        }
        return $this->attributes['role_ids'];
    }

    protected function getRoles()
    {
        if (isset($this->attributes['roles'])) {
            return $this->attributes['roles'];
        }
        $roleModel = new RoleModel();
        $this->attributes['roles'] = [];
        if (count($this->getRole_Ids()) > 0) {
            $roles = $roleModel->select('id,name,description')->find($this->getRole_Ids());
            foreach ($roles as $role) {
                array_push($this->attributes['roles'], $role->toArray());
            }
        }
        return $this->attributes['roles'];
    }


    protected function getPermissions()
    {
        $rolePermissionModel = new RolePermissionModel();
        $rolePermissionModel->whereIn("role_permissions.role_id", $this->getRole_Ids());
        $rolePermissionModel->join('permissions', 'permissions.id = role_permissions.permission_id');
        $rolePermissions = $rolePermissionModel->select('permissions.name')->find();
        $permissions = [];
        foreach ($rolePermissions as $permission) {
            array_push($permissions, $permission->name);
        }
        return $permissions;
    }

    protected function getImage()
    {
        if (isset($this->attributes['image'])) {
            return $this->attributes['image'];
        }
        $imageModel = new ImageModel();
        $images = $imageModel
            ->where([
                'imageable_type' => 'User',
                'imageable_id' => $this->id
            ])
            ->findAll();

        if (count($images) == 0) {
            return new \stdClass();
        }
        $this->attributes['image'] = $images[0];
        return $images[0];
    }

    public function with($name)
    {
        $functionName = 'get' . ucfirst($name);
        if (method_exists($this, $functionName)) {
            $this->$functionName();
        }
        return $this;
    }
}
