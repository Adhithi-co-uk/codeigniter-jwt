<?php

use Modules\Auth\Entities\User;
use Modules\Auth\Models\UserModel;

function loginUser(User $user)
{
    $request = \Config\Services::request();
    $request->user = $user;
}

function isLoggedIn()
{
    $request = \Config\Services::request();
    if ($request->user) {
        return TRUE;
    }
    return FALSE;
}

function getUsername()
{
    $request = \Config\Services::request();
    if (isLoggedIn()) {
        return $request->user->name;
    }
    return null;
}


function getUserid()
{
    $request = \Config\Services::request();
    if (isLoggedIn()) {
        return $request->user->id;
    }
    return null;
}

function getUser()
{
    $userModel = new UserModel();
    $request = \Config\Services::request();
    if (isLoggedIn()) {
        return  $userModel->find($request->user->id);
    }
    return null;
}

function getUserRoles()
{
    if (!isLoggedIn()) {
        return [];
    }
    $request = \Config\Services::request();
    return $request->user->roles;
}

function hasRole($role_name)
{
    $request = \Config\Services::request();
    if (!isLoggedIn()) {
        return FALSE;
    }
    foreach ($request->user->roles as $role) {
        if (strtolower($role) == strtolower($role_name)) {
            return TRUE;
        }
    }
    return FALSE;
}

function hasPermission($permission_name)
{
    $request = \Config\Services::request();
    if (!isLoggedIn()) {
        return FALSE;
    }
    foreach ($request->user->permissions as $permission) {
        if (strcasecmp($permission, $permission_name) == 0) {
            return TRUE;
        }
    }
    return FALSE;
}
