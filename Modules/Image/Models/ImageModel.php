<?php

namespace Modules\Image\Models;

use CodeIgniter\Model;


class ImageModel extends Model
{
    protected $table      = 'images';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name', 'thumbnail', 'medium', 'imageable_type', 'imageable_id', 'image', 'file_path', 'uri_path'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $afterDelete = ['deleteImageFiles'];
    // public $db = \Config\Database::connect();


    protected $validationRules    = [
        'name'     => 'required|min_length[3]',
        'thumbnail'     => 'required|min_length[3]',
        'medium'     => 'required|min_length[3]',
        'file_path'     => 'required|min_length[5]',
        'uri_path'     => 'required|min_length[5]',
    ];

    protected $validationMessages = [
        'name'        => [
            'alpha_numeric' => 'Please enter valid alpha numeric name.'
        ]
    ];


    protected function deleteImageFile(array $data)
    {
        $path = $data['path'];
        $name = $data['name'];
        $thumbnail = $data['thumbnail'];
        $medium = $data['medium'];


        if (file_exists(WRITEPATH . 'image/' . $path . '/' . $name) && !is_dir(WRITEPATH . 'image/' . $path . '/' . $name)) {
            unlink(WRITEPATH . 'image/' . $path . '/' . $name);
        }
        if (
            file_exists(WRITEPATH . 'image/' . $path . '/' . $thumbnail) &&
            !is_dir(WRITEPATH . 'image/' . $path . '/' . $thumbnail)
        ) {
            unlink(WRITEPATH . 'image/' . $path . '/' . $thumbnail);
        }
        if (
            file_exists(WRITEPATH . 'image/' . $path . '/' . $medium) &&
            !is_dir(WRITEPATH . 'image/' . $path . '/' . $medium)
        ) { {
                unlink(WRITEPATH . 'image/' . $path . '/' . $medium);
            }
        }
    }
}
