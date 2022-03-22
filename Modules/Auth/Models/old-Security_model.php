<?php

use CodeIgniter\Model;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class security_model extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $db = \Config\Database::connect();
    }

    public function getRoles()
    {
        $obj = new stdClass();
        $obj->status = 'success';
        $query = $this->db->get('role');
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $obj->status = 'fail';
            $obj->message = $error['message'];
        } else {
            $obj->results = $query->result();
        }
        return $obj;
    }

    public function getPermissions()
    {
        $obj = new stdClass();
        $obj->status = 'success';
        $query = $this->db->get('permission');
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $obj->status = 'fail';
            $obj->message = $error['message'];
        } else {
            $obj->results = $query->result();
        }
        return $obj;
    }

    public function getRolesPermission($conditions)
    {
        $obj = new stdClass();
        $obj->status = 'success';
        $this->db->where($conditions);
        $query = $this->db->get('permission_access');
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $obj->status = 'fail';
            $obj->message = $error['message'];
        } else {
            $obj->results = $query->result();
        }
        return $obj;
    }

    public function update_permission($data)
    {
        $obj = new stdClass();
        $obj->status = 'success';
        $PermissionData = array();
        $RolePermData = array();
        $PermissionTable = array('id', 'name', 'description');
        $RolePermTable = array('role', 'permission', 'access');
        foreach ($data as $key => $value) {
            if (in_array($key, $PermissionTable)) {
                $PermissionData[$key] = $value;
            } elseif (in_array($key, $RolePermTable)) {
                $RolePermData[$key] = $value;
            }
        }

        if (isset($PermissionData['id'])) {
            $condition = array(
                'id' => $PermissionData['id']
            );
            $this->db->where('id', $PermissionData['id']);
            $this->db->update('permission', $PermissionData);
        } else {
            $this->db->insert('permission', $PermissionData);
            $PermissionData['id'] = $this->db->insert_id();
            $RolePermData['permission'] = $this->db->insert_id();
        }

        $error = $this->db->error();
        if ($error['code'] == 1062) {
            $obj->status = 'fail';
            $obj->message = 'Duplicate entries not allowed';
            return $obj;
        } else if ($error['code'] != 0) {
            $obj->status = 'fail';
            $obj->message = $error['message'];
            return $obj;
        }

        $condition = array(
            'role' => $RolePermData['role'],
            'permission' => $RolePermData['permission']
        );
        $this->db->where($condition);
        $query = $this->db->get('permission_access');
        if ($query->num_rows() == 0 && $RolePermData['access'] == true) {
            $this->db->insert('permission_access', $condition);
        } elseif ($query->num_rows() != 0 && $RolePermData['access'] == false) {
            $this->db->delete('permission_access', $condition);
        }
        $error = $this->db->error();
        if ($error['code'] == 1062) {
            $obj->status = 'fail';
            $obj->message = 'Duplicate entries not allowed';
        } else if ($error['code'] != 0) {
            $obj->status = 'fail';
            $obj->message = $error['message'];
        } else {
            $obj->id = $PermissionData['id'];
            $obj->status = 'success';
        }
        return $obj;
    }

    public function update_role($data)
    {
        $obj = new stdClass();
        $obj->status = 'success';
        $RoleData = array();
        $RoleTable = array('id', 'name', 'description');
        foreach ($data as $key => $value) {
            if (in_array($key, $RoleTable)) {
                $RoleData[$key] = $value;
            }
        }
        if (isset($RoleData['id'])) {
            $this->db->where('id', $RoleData['id']);
            $this->db->update('role', $RoleData);
        } else {
            $this->db->insert('role', $RoleData);
            $RoleData['id'] = $this->db->insert_id();
            $obj->id = $RoleData['id'];
        }
        $error = $this->db->error();
        if ($error['code'] == 1062) {
            $obj->status = 'fail';
            $obj->message = 'Duplicate entries not allowed';
        } else if ($error['code'] != 0) {
            $obj->status = 'fail';
            $obj->message = $error['message'];
        }
        return $obj;
    }

    function delete_role($data)
    {
        $obj = new stdClass();
        $obj->status = 'success';
        if ($data->action == 'delete') {
            $this->db->where('id', $data->id);
            $this->db->delete('role');
        }

        $error = $this->db->error();
        if ($error['code'] != 0) {
            $obj->status = 'fail';
            $obj->message = $error['message'];
            return $obj;
        }

        $this->db->where('role', $data->id);
        $this->db->delete('permission_access');
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $obj->status = 'fail';
            $obj->message = $error['message'];
            return $obj;
        }
        return $obj;
    }

    public function delete_permission($data)
    {
        $obj = new stdClass();
        $obj->status = 'success';
        if ($data->action == 'delete') {
            $this->db->where('id', $data->id);
            $this->db->delete('permission');
        }

        $error = $this->db->error();
        if ($error['code'] != 0) {
            $obj->status = 'fail';
            $obj->message = $error['message'];
            return $obj;
        }

        $this->db->where('permission', $data->id);
        $this->db->delete('permission_access');
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $obj->status = 'fail';
            $obj->message = $error['message'];
            return $obj;
        }
        return $obj;
    }
}
