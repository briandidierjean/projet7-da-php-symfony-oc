# BileMo

## 1. Installation

### 1.1. Installation with Docker (recommended)

Here is the recommended installation with Docker that includes PHP, MySQL and phpMyAdmin to get a functional API in no
time.

  - Clone the repository
  - Go to the project root
  - Execute `docker-compose up` in your terminal
  - Execute `php bin/console doctrine:schema:update --force` in www_docker-symfony terminal
  - Execute `php bin/console doctrine:fixture:load` in www_docker-symfony terminal
  - Execute `php bin/console lexik:jwt:generate-keypair` in www_docker-symfony terminal
  - Create a *.env.local* file and add `APP_ENV=prod`

The API is ready ! Go to *localhost:8000* to interact with it and *localhost:8888* for phpMyAdmin.

### 1.2. Installation with LAMP

Here is the installation with a LAMP stack. You can use the web server of your choice as long as you can make it work
Symfony. You also need PHP 7.2, MySQL 8 and Composer.

  - Clone the repository
  - Go to the project root
  - Execute `composer install` in your terminal
  - Create a *env.local* file and add your database credentials
  - Execute `php bin/console doctrine:schema:update --force` in your terminal
  - Execute `php bin/console doctrine:fixture:load` in your terminal
  - Execute `php bin/console lexik:jwt:generate-keypair` in your terminal
  - Add `APP_ENV=prod` in *.env.local*

Now the API should work.

## 2. Documentation

When the API is on, you can go to the */doc* route to access the documentation.