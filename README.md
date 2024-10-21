------------
![](https://github.com/elMauro2003/imagenes/blob/main/CRUD%20Ajax%20Images/Header.png)

# Ajax CRUD

## Project Info
This is a small CRUD developed with **Laravel**, **jQuery**, **Bootstrap** and **AJAX**. It is 100% reactive, so your **HTTPs** requests will be made without refreshing the page, in order to improve the user experience.

## Dependencies
- You must have XAMPP installed [XAMPP](https://www.apachefriends.org/es/download.html "XAMPP") (versión **PHP** **8.1** o superior)  
- You must have [Composer](https://getcomposer.org/download/ "Composer") installed

## How to install locally
1. Clone or download the repository to a folder on Local

1. Open the repository in your favorite code editor (**Visual Studio Code**)

1. Run the **XAMPP** application and start the **Apache** and **MySQL** modules

1. Open a new terminal in your editor

1. Check that you have all dependencies installed correctly, run the following commands: **(Both commands should execute correctly - run in terminal)**
```bash
php -v
```
```bash
composer -v
```

1. Now run the commands for project setup (**run in terminal**):

- This command will install all the composer dependencies
```bash
composer install
```
- In the root directory you will find the file **.env.example**, duplicate it, rename the duplicate file as **.env**, this file must be modified according to the configurations of our project. There they are shown how it should look
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ajaxcrud 
DB_USERNAME=root
DB_PASSWORD=
```
- Run the command to create the Security Key
```bash
php artisan key:generate 
```
- Enter the administrator of [PHP MyAdmin](http://localhost/phpmyadmin/) and create a new database, the name is optional, but by default name it **ajaxcrud**

- Run the project migrations
```bash
php artisan migrate
```
```bash
php artisan db:seed
```
- Run the project
```bash
php artisan serve
```
## Support me
If this project has been useful to you, you can leave me a star, and if you have something to contribute, do not hesitate to leave your pull request.

------------


