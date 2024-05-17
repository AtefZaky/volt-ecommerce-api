<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Overview

Volt ecommerce api is an ecommerce api that have all the basic functionalities any ecommerce application will need.

You can check the documentation for the api from here:<br>
**NOTE: it still under development**:
[Documentation](https://documenter.getpostman.com/view/31966634/2sA3JRYe1D)

## Features

- Multi-authentication as Admin-User using Laravel breeze
- Product Management System
- Product filters and search
- Product and User Image Upload
- Order Management (Make order and Update order status)
- Cart management (Add to cart and Remove from Cart)
- Add Reviews to products

## Technologies

- PHP
- [Laravel](https://laravel.com/)
- [Laravel Breeze](https://github.com/laravel/breeze)

## Setup

clone the repo and install the dependency

```
git clone https://github.com/AtefZaky/volt-ecommerce-api.git
cd volt-ecommerce-api
composer install
```

you need to update the .env.example to .env 
and add your database configuration

Example:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=volt
DB_USERNAME=root
DB_PASSWORD=
```

Generate application key
```
php artisan key:generate
```

Run the migration for the database
```
php artisan migrate
```

Seed the database:
This command will seed the database with one admin user
```
php artisan db:seed
```
Make a virtual link between the storage and the public folder to make uploaded files publicly accessible.<br>
This is needed when uploading the product and user image
```
php artisan storage:link
```
Finaly run the app
```
php artisan serve
```

**Note:** if you want to use the forget my password feature.<br>
You need to setup the Email Delivery you can use: [mailtrap](https://mailtrap.io/) for this <br>
and add the configuration here in the .env file
```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=username
MAIL_PASSWORD=password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```


## Author

LinkedIn: [Atef Zaky](https://www.linkedin.com/in/atef-zaky-21b933232/)<br>

## Contributions

If you face any problem or have any suggestions to make the performance better,<br> Please fork, Make the necessary changes, and create a pull request so I can review your changes and merge them into the main repo.

Thank you. 😊✌️
