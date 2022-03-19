<?php

use CodeIgniter\Files\File;

function resizeImage($uploadedPath, $subdir = "")
{
    $path = WRITEPATH . "uploads/" . $uploadedPath;
    $targetDir = $subdir == "" ? WRITEPATH . "images" : WRITEPATH . "images/" . $subdir;
    $file = new \CodeIgniter\Files\File($path);
    $image = \Config\Services::image();
    $imageConfig = new \Config\Images();

    $thumbnailSize = $imageConfig->thumnailSize;
    $mediumSize = $imageConfig->mediumSize;


    $file = $file->move($targetDir);
    print_r($file);

    $destination = File::getDestination($file->getPathname());

    // echo $destination;
    $image
        ->withFile($file->getPathname())
        ->resize($thumbnailSize['width'], $thumbnailSize['height'], true)
        ->save($destination);

    $destination = File::getDestination($file->getPathname());

    // echo $destination;
    $image
        ->withFile($file->getPathname())
        ->resize($mediumSize['width'], $mediumSize['height'], true)
        ->save($destination);
}
