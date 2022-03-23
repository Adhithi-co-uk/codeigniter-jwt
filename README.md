# CodeIgniter 4 Application Starter Kit With JWT Rolebased Authentication

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](http://codeigniter.com).

## Why is this Starter kit for?

This starter kit contains the role based security implementation as a module which you can use in your application. You can download and run the migrations and seeder to create database tables and populate test data then try the code.

## Setup

Once you are familiar with the functionalities available in this starter kit you can start using it. For using the Auth module just the Modules\\\* directory to your route of your project directory and update the autoload config file to load the module. After that you could use it already.

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
