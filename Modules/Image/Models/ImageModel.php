<?php

namespace Modules\Image\Models;

use CodeIgniter\Model;


class ImageModel extends Model
{
    protected $table      = 'images';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name', 'thumbnail', 'medium', 'imageable_type', 'imageable_id', 'image', 'ext', 'path', 'status'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $afterDelete = ['deleteImageFiles'];
    // public $db = \Config\Database::connect();


    protected $validationRules    = [
        'name'     => 'required|alpha_numeric|min_length[3]',
        'description'     => 'required|min_length[8]',
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
