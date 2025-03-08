Overview

This is a simple user registration and login system built with vanilla PHP and MySQL. Users can register with their fullname, email, profile photo and password.

Features

User registration with email and password

Secure password hashing

User authentication (login/logout)

File upload functionality

Session management

MySQL database integration

Technologies Used

PHP (Core PHP, no framework)

MySQL (Database)

HTML, CSS, JavaScript, Bootstrap

Requirements

PHP 8.1 or later

MySQL database

Apache web server

Installation

Clone the repository:

git clone https://github.com/Avinash-advik/user-auth-php.git
cd your-repo

Configure the database:

Create a MySQL database:  
CREATE DATABASE user_auth_php;

Import the database.sql file to set up tables.

Update database/dbconnect.php with your database credentials.

Start the Apache server:
Access the application in your browser:
http://localhost/user-auth-php