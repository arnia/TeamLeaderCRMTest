# Teamleadercrm

Teamleadercrm discount test

#### Prerequisites:

PHP 7+
Apache 2.4.29
MariaDB 10.1.30

#### Installation with WAMP/XAMPP:

##### Clone the project files
```bash
git clone git@github.com:arnia/TeamLeaderCRMTest.git
```
*for wamp you can clone in folder /www; for xampp is /htdocs)

##### Change the file .env and add your database config example by default i have already configured my local config:

```bash
    DB_DATABASE=teamleader
    DB_USERNAME=root
    DB_PASSWORD=
```
*don't forget to create your database in MySQL

##### Update application packages and dependencie
```bash
composer install
```
*you need to have the latest composer version installed

##### Add the cripting key for laravel/homestead
```bash
php artisan key:generate
```
*php need to already be set as environment variable

##### Run all database migrations and seeds
```bash
composer dump-autoload
php artisan migrate:refresh --seed
```

##### To access the app you can make a virtual host pointing to public folder of the app. To do that you can add in httpd-vhosts.conf:
```bash
<VirtualHost *:80>
    ServerName discount-test
    DocumentRoot "C:/xampp/htdocs/Teamleadercrm/discount-test/public"
    SetEnv APPLICATION_ENV "development"
    <Directory "C:/xampp/htdocs/Teamleadercrm/discount-test/public">
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```
*also add ```127.0.0.1 discount-test``` in your hosts file

After this you can send request orders in your browser to the following endpoint
```bash
http://discount-test/api/discount
```
To test the order requests i've used the Postman application on my local you have [here](/discount-test/postman_screens/) some print screens

Unit test ar found in the folder /tests/Unit/DiscountTest.php you can run them with PHPUnit.
