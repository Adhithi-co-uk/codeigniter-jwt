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
        $name = $this->request->getVar("name");
        $limit = $this->request->getVar("limit");
        $offset = $this->request->getVar("offset");

        if (!$limit) {
            $limit = 10;
        }
        if (!$offset) {
            $offset = 0;
        }

        // if (!hasPermission('user_manage')) {
        //     return $this->respond([
        //         'message' => 'No access'
        //     ], 403);
        // }
        $users = new UserModel();
        // return $this->respond(['users' => $users->select(['id', 'name', 'email', 'created_at'])->findAll()], 200);
        return $this->respond($users->search_list($name, $limit, $offset));
    }

    public function me()
    {
        $user = new UserModel();
        $me = $user->select('id,name,email')->find($this->request->user->id)->with("roles")->with("images");
        return $this->respond($me, 200);
    }
}
