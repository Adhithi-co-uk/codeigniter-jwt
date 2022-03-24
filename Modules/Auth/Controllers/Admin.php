<?php

namespace Modules\Auth\Controllers;

// use App\Controllers\AdminController;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use Modules\Auth\Models\RoleModel;
use Modules\Auth\Models\UserModel;
use Modules\Auth\Models\UserRoleModel;
use stdClass;

class Admin extends Controller
{
    use ResponseTrait;

    public $messages = array();

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        // $this->session = \Config\Services::session();
    }

    public function get()
    {
        $obj = new stdClass();

        helper('Modules\Auth\Auth');

        if (!hasPermission('manage_user')) {
            return $this->respond([
                'status' => 'fail',
                'message' => 'You don\'t have permission to access the data'
            ], 403);
        }

        $request_body = json_decode(file_get_contents('php://input'));
        $page = $request_body->page;
        $limit = $request_body->limit;
        $query = $request_body->query;
        $offset = $limit * ($page - 1);
        $userModel = new UserModel();
        // echo $query;
        $users = $userModel->search_list($offset, $limit, $query);
        // echo $userModel->getLastQuery();
        $obj->Users = $users->result;
        $obj->pageCount = $users->pageCount;
        $obj->currentPage = $users->currentPage;
        return $this->response->setJSON($obj);
    }

    public function get_one($user_id)
    {
        $obj = new \stdClass();
        $obj->status = 'success';
        $obj->message = '';
        if (!hasPermission('manage_user')) {
            $obj->status = 'fail';
            $obj->message = 'You don\'t have permission to access the data';
            return $this->response->setJSON($obj);
        }

        $roleModel = new RoleModel();
        $roles = $roleModel->asObject()->find();
        $userModel = new UserModel();
        $user = $userModel->find($user_id);

        $user->image = $user->image;
        $user_roles = $user->roles;
        foreach ($roles as $role) {
            $role->granted = false;
            foreach ($user_roles as $user_role) {
                if ($role->id == $user_role->id) {
                    $role->granted = true;
                }
            }
        }
        $result = new \stdClass;
        $result->user = $user;
        $result->roles = $roles;
        return $this->response->setJSON($result);
    }

    public function save()
    {
        $obj = new \stdClass();
        $obj->status = 'success';
        $obj->message = '';
        if (!hasPermission('manage_user')) {
            $obj->status = 'fail';
            $obj->message = 'You don\'t have permission to access the data';
            return $this->response->setJSON($obj);
        }
        $user_id = $this->request->getPost('id');
        $validation =  \Config\Services::validation();
        if ($validation->withRequest($this->request)->run(null, 'user_update')) {
            $userModel = new UserModel();
            $userModel->save($this->request->getPost());

            $userRoleModel = new UserRoleModel();
            $userRoleModel->where('user_id', $user_id)->delete();
            $roles = json_decode($this->request->getPost('role'));
            foreach ($roles as $role) {
                if ($role->granted != true) {
                    continue;
                }
                $userrole = [
                    'role_id' => $role->id,
                    'user_id' => $user_id
                ];
                $userRoleModel->insert($userrole);
            }
            $userRoleModel->resetQuery();
            return $this->response->setJSON($obj);
        } else {
            $this->response->setStatusCode(400, 'Data validation failed');
            $obj->status = 'fail';
            $obj->message = 'Data validation failed';
            return $this->response->setJSON($obj);
        }
    }

    public function registration_monthly()
    {
        if (!hasPermission('manage_user')) {
            $obj = new stdClass();
            $obj->status = 'fail';
            $obj->message = 'You don\'t have permission to access the data';
            echo json_encode($obj);

            return;
        }
        $this->load->model('User_Model', 'User');
        $Results = $this->User->registration_monthly();
        $labels = array();
        $data = array();
        $dataTotal = array();
        foreach ($Results as $result) {
            array_push($labels, $result->Date);
            array_push($data, $result->Value);
        }
        $result = new stdClass();
        $result->labels = $labels;
        $result->datasets = array();
        $dataset2 = new stdClass();
        $dataset2->label = 'User Signup Monthly';
        $dataset2->fillColor = 'rgba(220,220,220,0.2)';
        $dataset2->strokeColor = 'rgba(220,220,220,1)';
        $dataset2->pointColor = 'rgba(220,220,220,1)';
        $dataset2->pointStrokeColor = '#fff';
        $dataset2->pointHighlightFill = '#fff';
        $dataset2->pointHighlightStroke = 'rgba(220,220,220,1)';
        $dataset2->data = $data;
        array_push($result->datasets, $dataset2);
        echo json_encode($result);
    }

    public function signup_method()
    {
        if (!hasPermission('manage_user')) {
            $obj = new stdClass();
            $obj->status = 'fail';
            $obj->message = 'You don\'t have permission to access the data';
            echo json_encode($obj);

            return;
        }
        $this->load->model('User_Model', 'User');
        $data = array();
        $Results = $this->User->registration_provider();
        $color = ['#F7464A', '#46BFBD', '#FDB45C'];
        $highlight = ['#FF5A5E', '#5AD3D1', '#FFC870'];
        $i = 0;
        foreach ($Results as $result) {
            $entry = new stdClass();
            $entry->label = $result->Provider;
            $entry->value = $result->Value;
            $entry->color = $color[$i];
            $entry->highlight = $highlight[$i];
            array_push($data, $entry);
            ++$i;
        }
        //print_r($data);
        echo json_encode($data);
    }

    public function UserCount()
    {
        $obj = new stdClass();
        $obj->status = 'success';
        $obj->message = '';
        if (!hasPermission('manage_user')) {
            $obj->status = 'fail';
            $obj->message = 'You don\'t have permission to access the data';
            return $this->response->setJSON($obj);
        }
        $userModel = new UserModel();
        $obj->count = $userModel->countAll();
        return $this->response->setJSON($obj);
    }


    public function impersonate($user_id)
    {
        $obj = new \stdClass();
        $obj->status = 'success';
        $obj->message = '';
        if (!hasPermission('manage_user')) {
            $obj->status = 'fail';
            $obj->message = 'You don\'t have permission to access the data';
            return $this->response->setJSON($obj);
        }
        $userModel = new UserModel();
        $user = $userModel->find($user_id);
        $roles = [];
        $user_roles = $user->roles;
        foreach ($user_roles as $role) {
            array_push($roles, $role->name);
        }
        $permissions = [];
        $user_permissions = $user->permissions;
        foreach ($user_permissions as $permission) {
            array_push($permissions, $permission->name);
        }
        session()->set(array(
            'username' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'impersonater' => getUsername(),
            'permissions' => $permissions,
            'userrole' => $roles,
        ));
    }
}
