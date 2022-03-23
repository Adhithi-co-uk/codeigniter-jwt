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

    protected function getRoleIds()
    {
        if ($this->role_ids != null) {
            return $this->role_ids;
        }

        $userRoleModel = new UserRoleModel();
        $user_roles = $userRoleModel->where('user_id', $this->id)->select('role_id')->findAll();
        $roles = [];
        foreach ($user_roles as $role) {
            array_push($roles, $role->role_id);
        }
        return $roles;
    }

    protected function getRoles()
    {
        if ($this->roles != null) {
            return $this->roles;
        }
        $roleModel = new RoleModel();

        if (count($this->getRoleIds()) > 0) {
            $roles = $roleModel->select('id,name,description')->find($this->getRoleIds());
        }
        $this->roles = $roles;
        return $roles;
    }


    protected function getPermissions()
    {
        $rolePermissionModel = new RolePermissionModel();
        $rolePermissionModel->whereIn("role_permissions.role_id", $this->getRoleIds());
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
        if ($this->image != null) {
            return $this->image;
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
        $this->image = $images[0];
        return $images[0];
    }

    //Call functions to load relationships then return the instance
    public function with($name)
    {
        $functionName = 'get' . ucfirst($name);
        if (method_exists($this, $functionName)) {
            $this->$functionName();
        }
        return $this;
    }
}
