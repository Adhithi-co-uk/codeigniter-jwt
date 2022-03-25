# JWT Rolebased Security module for CodeIgniter 4

## Why is this Module?

This Auth module is for adding role based security implementation for any CodeIgniter 4 applications. If you starting a new CodeIgniter project you can use this as a starter kit otherwise can use the Auth Module from this project and include in your project. This module contain database migrations and seeders to create sample users and roles.

Quick start guide for using the module is given below and the detail writeup is available at my blog [aboutfullstack.com](https://aboutfullstack.com) at [https://aboutfullstack.com/codeigniter/codeigniter-4-security-module-jwt-rolebased-permissions-etc/](https://aboutfullstack.com/codeigniter/codeigniter-4-security-module-jwt-rolebased-permissions-etc/)

## Setup for existing projects

- Download the code and compy the Modules directory to the root of your project parallel to app directory
- Update the app/config/autoload.php to include autoloading for the module as shown below

```php
    public $psr4 = [
        APP_NAMESPACE => APPPATH, // For custom app namespace
        'Config'      => APPPATH . 'Config',
        'Modules\Auth' => ROOTPATH . 'Modules/Auth',
        'Modules\Image' => ROOTPATH . 'Modules/Image',
        // 'Modules/Image' => ROOTPATH . 'Modules/Image'
    ];

```

- Run the migrations using php spark migrate to create required tables **php spark migrate**
- Run the seeder to populate sample users for testing **php spark db:seed AuthData**

Now the auth module is integrated and you can start using it. See below usage instructions to know how to use it.

## Setup for new projects

- Download this repository
- Run **composer install** in the root of the project
- Run the migrations using php spark migrate to create required tables **php spark migrate**
- Run the seeder to populate sample users for testing **php spark db:seed AuthData**

Now you are ready with the CodeIgniter starter kit with Role based authorization module.

## Usage

The module contains filter to secure the route also some helper methods which can be used within the controller to implement role / permission based logics.

### Filters

There are two filters available with this package. One is named **Throttle** and the other one is named **AuthFilter**.

"Throttle" is used to avoid hackers trying multiple call (DoS Attack) to the login end point to try out different email / password combinations to gain access to the application. Currently 3 attempts is possible to the login end point with wrong username and password combination in one minute time span. You can change this in the file app/Filters/Throttle.php.

"AuthFilter" is used in the routes protect the end point which can only be accessed by the logged in users. Below is the code from route config inside the Auth module. As seen below the authFilter if used without parameter will allow if user logged in to the application. AuthFilter accept permission names as optional parameter when passed it will check whether the user got the all the permissions passed before granting access. Multiple permissions can be passed as comma seperated values such as ['filter' => 'authFilter:manage_user,admin'].

```php

namespace Modules\Auth\Config;

$routes->group('api', ['namespace' => 'Modules\Auth\Controllers'], function ($routes) {
    $routes->post("register", "Register::index");
    $routes->post("login", "Login::index");
    $routes->get("users", "User::index", ['filter' => 'authFilter:user_manage']);
    $routes->get("users/me", "User::me", ['filter' => 'authFilter']);
});

```

With the above configuration users/me route is accessible by any logged in users and users/ route is accessible by users having permission "user_manage".

### Helper functions

The helper functions are available for checking whether logged in user has got given role or permission. It is useful to implement permission based functionalities within the controllers. The following helper functions are available.

- **hasRole($role_name)** - Checks whether the user got given role
- **hasPermission($permission_name)** - Checks whether the user got given permission
- **isLoggedIn()** - Return true/false based on whether user is logged in
- **getUsername()** - Returns the Name of the logged in User.
- **getUserid()** - Returns the id of the logged in user
- **getUser()** - Returns the user instance of the logged in user with all attributes
- **loginUser(User $user)** - Logs in the user. Used by the AuthFilter to set the User id to the request object after validating the JWT

For using this function first needs to load the helper then can call this function as shown below.

```php

  helper('Modules\Auth\Auth');

    if (!hasPermission('manage_user')) {
        return $this->respond([
            'status' => 'fail',
            'message' => 'You don\'t have permission to access the data'
        ], 403);
    }

```

## Server Requirements

PHP version 7.3 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)

```

```
