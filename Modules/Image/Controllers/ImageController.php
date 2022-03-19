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
            // echo view('upload_form', ['error' => "upload failed"]);

            $this->respond($path);
        } else {
            helper('Modules\Image\Image');
            resizeImage($path);
            echo $path;
        }

        // $obj = new stdClass();
        // $obj->uploaded = 0;
        // if (isNotLoggedIn()) {
        //     if (strpos($_SERVER['HTTP_REFERER'], 'user/signup') == false) {
        //         $obj->error->message = 'Not logged in';
        //         echo json_encode($obj);
        //         return;
        //     }
        // }

        // $this->load->model('pcg_model', 'file');
        // $config['upload_path'] = ASSET_PATH . 'image/user_image';
        // $config['allowed_types'] = 'png|jpg|gif|jpeg';
        // $this->load->library('upload', $config);
        // $imageUpload = new stdClass;
        // if (isset($_FILES['upload']) && $_FILES['upload']['name'] != '') {
        //     if ($this->upload->do_upload('upload')) {
        //         $upload_data = $this->upload->data();
        //         $imageUpload->name = $upload_data['file_name'];
        //         $imageUpload->thumbnail = $upload_data['raw_name'] . "_thumbnail" . $upload_data['file_ext'];
        //         $imageUpload->medium = $upload_data['raw_name'] . "_medium" . $upload_data['file_ext'];
        //         $imageUpload->path = 'user_image';
        //         $imageUpload->ext = $upload_data['file_ext'];
        //         $image_path = $upload_data['full_path'];
        //         $filename = $upload_data['raw_name'];
        //         $this->load->library('Image_lib');
        //         $config['image_library'] = 'GD2';
        //         $config['source_image'] = $image_path;
        //         $config['new_image'] = realpath(ASSET_PATH . "image/user_image") . "/" . $filename . "_thumbnail" . $upload_data['file_ext'];
        //         $config['maintain_ratio'] = FALSE;
        //         $config['height'] = 200;
        //         $config['width'] = 200;
        //         $this->image_lib->initialize($config);
        //         $this->image_lib->resizeThenCrop();
        //         $config['new_image'] = realpath(ASSET_PATH . "image/user_image") . "/" . $filename . "_medium" . $upload_data['file_ext'];
        //         $config['maintain_ratio'] = TRUE;
        //         $config['height'] = '600';
        //         $config['width'] = '600';
        //         $this->image_lib->initialize($config);
        //         $this->image_lib->resizeThenCrop();

        //         $image_data['name'] = $imageUpload->name;
        //         $image_data['medium'] = $imageUpload->medium;
        //         $image_data['thumbnail'] = $imageUpload->thumbnail;
        //         $image_data['path'] = $imageUpload->path;
        //         $image_data['ext'] = $imageUpload->ext;
        //         $data['image'] = $this->file->insert($image_data, 'image');
        //         $obj->uploaded = 1;
        //         $obj->fileName = $imageUpload->name;
        //         $obj->url = image_asset_url($image_data['path'] . '/' . $image_data['medium']);
        //         $obj->id = $data['image'];
        //         echo json_encode($obj);
        //     } else {
        //         $obj->uploaded = 0;
        //         $obj->error = new stdClass();
        //         $obj->error->message = $this->upload->display_errors('', '');
        //         echo json_encode($obj);
        //     }
        // } else {
        //     $obj->uploaded = 0;
        //     $obj->error = new stdClass();
        //     $obj->error->message = "File is not posted";
        //     echo json_encode($obj);
        // }
    }
}
