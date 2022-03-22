<?php

namespace Modules\Auth\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Modules\Auth\Models\UserModel;

class User extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        if (!hasPermission('user_manage')) {
            return $this->respond([
                'message' => 'No access'
            ], 403);
        }
        $users = new UserModel();
        // return $this->respond(['users' => $users->select(['id', 'name', 'email', 'created_at'])->findAll()], 200);
        return $this->respond($users->search_list("Nish", 10, 0));
    }

    public function me()
    {
        helper("Modules/Auth/Auth");
        return isLoggedIn();
    }
}
