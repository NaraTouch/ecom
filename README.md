# Migration Guide:

#### Note: Only for git users or updating by zip file from the release section from repository

# Prerequisites
**PHP: 7.4 or higher.**
**Composer: 1.6.5 or higher**

# Install and Migration Guide:

## 1. Be aware of you Database connection
> **Copy and rename .env.example to .env**
> **Fill your database connection detail there**
**Example for MySQL**
**database driver as mysql we also support another database as well like pgsql, sqlite and sqlsrv.**
> **DB_CONNECTION=mysql**

**127.0.0.1 is your database ip if your running no differenc server please check it and put ip connection here**
> **DB_HOST=127.0.0.1**

**defaul port for mysql if you are using difference port can change it**
> **DB_PORT=3306**

**ecommerce is your database name**
> **DB_DATABASE=ecommerce**

**database user name first time run may require all privillage user like root.**
> **DB_USERNAME=root**

**database password**
> **DB_PASSWORD=123456**

## 2. Install package dependancy by conposer

> **composer install**

## 3. Generate the application key

> **php artisan key:generate**

## 3. Install Migration database

> **php artisan migrate**

> **php artisan db:seed**

## 3. Configuration, assets (CSS, js, images, etc) and all necessary files will be copied to the specified publish location.

> **php artisan vendor:publish**
> **-> Press 0 and then press enter to publish all assets and configurations.**

## 3. Link of storage directory with the public

> **php artisan storage:link**

## DONE ##

## ADMIN DEFAUL USER
> **url:{host}/dmin/login**
> **email:admin@example.com**
> **password:admin123**