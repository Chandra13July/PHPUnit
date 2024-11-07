# Authentication System

## Description

This project implements an **Authentication System** using **PHP**, **MySQL**, and **MVC (Model-View-Controller)** architecture. It includes features for **Login**, **Signup**, and **Password Recovery**.

- **Login**: Allows users to log in using their username or email and password.
- **Signup**: Users can create new accounts by providing a username, email, and password.
- **Forgot Password**: Allows users to reset their password via an email link.
- **Role-Based Authentication**: Differentiates between Admin and Staff roles.

## Features

### Authentication System
- **Login**: Allows users to log in with either their username or email and password.
- **Signup**: New users can create an account by providing necessary details such as username, email, and password.
- **Forgot Password**: Users can reset their password by receiving a reset link via email.
- **Role-Based Access Control**:
  - **Admin**: Has full access to manage users and view all data.
  - **Staff**: Can view their personal data and limited access.

## Technologies Used
- **PHP**: Server-side scripting language for handling authentication logic.
- **MySQL**: Database for storing user credentials.
- **HTML/CSS**: Front-end technologies for building the user interface.
- **PDO (PHP Data Objects)**: Secure and efficient method for database interactions.

## Prerequisites

Before running the project locally, ensure that you have the following software installed:
- **PHP** >= 7.4
- **MySQL**: For managing the database
- **Composer**: To install dependencies

## Installation

### Step 1: Clone the Repository

Clone the project repository to your local machine:

```bash
git clone https:https://github.com/Chandra13July/PHPUnit.git
```
Step 2: Install Dependencies
Navigate to the project directory and install the required dependencies using Composer:

```bash
cd authentication-system
composer install
```

Step 3: Set Up the Database
Create a new database, e.g., auth_db, in MySQL.

Configure the Database Connection:
Open the app/config/database.php file and modify the database credentials to match your MySQL setup:

```bash
<?php
return [
    'host' => 'localhost',
    'dbname' => 'auth_db',  // Your database name
    'username' => 'root',    // Your MySQL username
    'password' => '',        // Your MySQL password
];
```

Step 4: Create the Users Table
Execute the following SQL script to create the users table for the authentication system:

```bash
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Staff') DEFAULT 'Staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Step 5: Run the Application
To start the application, use PHP's built-in server:
```bash
php -S localhost:8000 -t public
```

Project Structure
```bash
authentication-system/
├── app/
│   ├── Controllers/            # Controller classes
│   │   ├── AuthController.php  # Handles login, signup, and forgot password logic
│   ├── Models/                 # Model classes for database interactions
│   │   └── UserModel.php       # Manages user data interactions
│   ├── Views/                  # View files (HTML/PHP for UI)
│   │   ├── auth/               # Auth-related views
│   │   │   ├── login.php       # Login form view
│   │   │   ├── signup.php      # Signup form view
│   │   │   ├── forgot-password.php # Forgot password view
│   ├── config/                 # Configuration files
│   │   └── database.php        # Database connection settings
├── public/                     # Public files
│   └── index.php               # Main entry point for the app
├── composer.json               # Composer dependency manager file
├── .gitignore                  # Git ignore file
├── phpunit.xml                 # PHPUnit configuration file
└── README.md                   # Project documentation
```

Running Tests
Unit tests are provided for validating the core functionality of the app, such as user authentication.

To run the tests:
1. Install PHPUnit if you haven’t already, using Composer:

```bash
composer require --dev phpunit/phpunit
```
2. Run the tests:
 
```bash
./vendor/bin/phpunit
```
You should see output like this if all tests pass:

```bash
PHPUnit 10.5.38 by Sebastian Bergmann and contributors.

...                                                                 3 / 3 (100%)

Time: 00:00.719, Memory: 8.00 MB

OK (3 tests, 3 assertions)

```
Example Code: AuthController
AuthController.php (Controller for Authentication Operations)

```bash
<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $emailOrUsername = $_POST['emailOrUsername'];
            $password = $_POST['password'];

            // Validate user credentials
            $user = UserModel::findByEmailOrUsername($emailOrUsername);

            if ($user && password_verify($password, $user['password'])) {
                // Set session and redirect
                $_SESSION['user_id'] = $user['id'];
                header('Location: /dashboard');
            } else {
                // Invalid credentials
                $error = "Invalid email/username or password.";
            }
        }

        include 'app/views/auth/login.php';
    }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            // Save the new user
            UserModel::create($username, $email, $password);
            header('Location: /login');
        }

        include 'app/views/auth/signup.php';
    }

    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];

            // Logic to send reset link to user's email
            UserModel::sendPasswordResetLink($email);
        }

        include 'app/views/auth/forgot-password.php';
    }
}
```
UserModel.php (Model for Interacting with the Database)

```bash
<?php

namespace App\Models;

use PDO;

class UserModel
{
    private static $db;

    public static function init()
    {
        self::$db = new PDO("mysql:host=localhost;dbname=auth_db", 'root', '');
    }

    public static function create($username, $email, $password)
    {
        $stmt = self::$db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
    }

    public static function findByEmailOrUsername($emailOrUsername)
    {
        $stmt = self::$db->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$emailOrUsername, $emailOrUsername]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function sendPasswordResetLink($email)
    {
        // Logic to send a password reset link to the user's email address
    }
}
```
