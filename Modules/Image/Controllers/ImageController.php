<?php

namespace Modules\Image\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Modules\Image\Models\ImageModel;

class ImageController extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        return $this->respond("", 200);
    }


    function all($name = '')
    {
        $model = new ImageModel();
        // if ($name != "") {
        //     return $model->findAll();
        // }
        return $this->respond($model->findAll());
    }

    function delete()
    {

        // $obj = new stdClass();

        // if (isNotLoggedIn()) {
        //     $obj->status = 'fail';
        //     $obj->message = 'Please login to access this feature';
        //     echo json_encode($obj);
        //     return;
        // }

        // $id = $this->input->post('id');

        // if (hasNoAccess('manage_images')) {
        //     log_message("error", "No access to the user " . getUsername() . ' for music ' . $id);
        //     $obj->status = 'fail';
        //     $obj->message = 'No access for this endpoint';
        //     echo json_encode($obj);
        //     return;
        // }


        // $Image = $this->__getById($id);
        // if (!$Image) {
        //     log_message('error', 'Image not found with id ' . $id);
        //     $obj->status = 'fail';
        //     $obj->message = 'Not found';
        //     echo json_encode($obj);
        //     return;
        // }

        // if ($this->image->delete($id)) {
        //     $obj->status = "success";
        //     $obj->message = 'Deleted successfully';
        //     echo json_encode($obj);
        // } else {
        //     $obj->status = 'fail';
        //     $obj->message = 'Failed to delete';
        //     echo json_encode($obj);
        // }
    }

    function add()
    {
        $this->validate([
            'userfile' => 'uploaded[userfile]|max_size[userfile,100]'
                . '|mime_in[userfile,image/png,image/jpg,image/gif]'
                . '|ext_in[userfile,png,jpg,gif]|max_dims[userfile,1024,768]'
        ]);

        $file = $this->request->getFile('userfile');
        if (!$path = $file->store()) {
            return $this->respond([
                'message' => 'Error occurred while uploading the image'
            ], 500);
        }
        helper('Modules\Image\Image');
        $result = uploadImage($path);
        if (!$result) {
            return $this->respond([
                'message' => 'Error occurred while uploading the image'
            ], 500);
        }
        $imageModel = new ImageModel();
        // $db = \Config\Database::connect();

        $id = $imageModel->insert($result, true);

        // print_r($result);
        // echo $imageModel->getLastQuery();


        // $imageModel->save($result);
        return $this->respond($imageModel->find($id));
    }
}
