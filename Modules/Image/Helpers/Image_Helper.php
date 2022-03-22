<?php

use CodeIgniter\Files\File;

function uploadImage($uploadedPath, $subdir = "")
{
    $imageInfo = [];
    try {


        $path = WRITEPATH . "uploads/" . $uploadedPath;
        $targetDir = $subdir == "" ? WRITEPATH . "images" : WRITEPATH . "images/" . $subdir;
        $file = new \CodeIgniter\Files\File($path);
        $image = \Config\Services::image();
        $imageConfig = new \Config\Images();

        $thumbnailSize = $imageConfig->thumnailSize;
        $mediumSize = $imageConfig->mediumSize;

        $file = $file->move($targetDir);
        $path = $file->getPathname();

        $imageInfo['name'] = $file->getFilename();
        $imageInfo['file_path'] = $file->getPath();
        $imageInfo['uri_path'] = $imageConfig->IMG_URL_PATH;

        $destination = File::getDestination($path);

        // echo $destination;
        $image
            ->withFile($file->getPathname())
            ->resize($thumbnailSize['width'], $thumbnailSize['height'], true)
            ->save($destination);

        $file =  new File($destination);
        $imageInfo['thumbnail'] = $file->getFilename();
        $destination = File::getDestination($path);
        $image
            ->withFile($file->getPathname())
            ->resize($mediumSize['width'], $mediumSize['height'], true)
            ->save($destination);
        $file =  new File($destination);
        $imageInfo['medium'] = $file->getFilename();
        return $imageInfo;
    } catch (Exception $exc) {
        log_message('error', $exc->getMessage());
        return FALSE;
    }
}
