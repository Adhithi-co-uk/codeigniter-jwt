<?php

namespace Modules\Auth\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Modules\Auth\Models\UserModel;

class Register extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $rules = [
            'name' => [
                'rules' => 'required|min_length[3]'
            ],
            'email' => ['rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[users.email]'],
            'password' => ['rules' => 'required|min_length[8]|max_length[255]'],
            'confirm_password'  => ['label' => 'confirm password', 'rules' => 'matches[password]']
        ];


        if ($this->validate($rules)) {
            $model = new UserModel();
            $data = [
                'name'    => $this->request->getVar('name'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            if ($model->save($data)) {
                return $this->respond(['message' => 'Registered Successfully'], 200);
            } else {
                return $this->respond(['message' => 'Failed to register'], 400);
            }
        } else {
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response, 409);
        }
    }
}
