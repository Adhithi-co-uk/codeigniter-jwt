# JWT Rolebased Security module for CodeIgniter 4

## Why is this Module?

This Auth module is for adding role based security implementation for any CodeIgniter 4 applications. If you starting a new CodeIgniter project you can use this as a starter kit otherwise can use the Auth Module from this project and include in your project. This module contain database migrations and seeders to create sample users and roles.

## Setup for existing projects

- Download the code and compy the Modules directory to the root of your project parallel to app directory
- Update the app/config/autoload.php to include autoloading for the module as shown below

````php
    public $psr4 = [
        APP_NAMESPACE => APPPATH, // For custom app namespace
        'Config'      => APPPATH . 'Config',
        'Modules\Auth' => ROOTPATH . 'Modules/Auth',
        'Modules\Image' => ROOTPATH . 'Modules/Image',
        // 'Modules/Image' => ROOTPATH . 'Modules/Image'
    ];

    ```
- Run the migrations using php spark migrate to create required tables **php spark migrate**
- Run the seeder to populate sample users for testing  **php spark db:seed AuthData**

Now the auth module is integrated and you can start using it. See below usage instructions to know how to use it.

## Setup for new projects

## Usage

The module contains filter to secure the route also some helper methods which can be used within the controller for securing the application.

## Server Requirements

PHP version 7.3 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)
````
