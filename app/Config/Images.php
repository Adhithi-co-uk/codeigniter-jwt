<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Images\Handlers\GDHandler;
use CodeIgniter\Images\Handlers\ImageMagickHandler;

class Images extends BaseConfig
{
    /**
     * Default handler used if no other handler is specified.
     *
     * @var string
     */
    public $defaultHandler = 'gd';

    /**
     * The path to the image library.
     * Required for ImageMagick, GraphicsMagick, or NetPBM.
     *
     * @var string
     */
    public $libraryPath = '/usr/local/bin/convert';

    /**
     * The available handler classes.
     *
     * @var array<string, string>
     */
    public $handlers = [
        'gd'      => GDHandler::class,
        'imagick' => ImageMagickHandler::class,
    ];

    public $thumnailSize = [
        "width" => 300,
        "height" => 300
    ];
    public $mediumSize = [
        "width" => 800,
        "height" => 800
    ];

    public $IMG_UPLOAD_PATH = WRITEPATH . "images";
    public $IMG_URL_PATH = "/images/uploads";
}
