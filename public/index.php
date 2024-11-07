<?php
require_once '../vendor/autoload.php';

use App\Controllers\AuthController;

session_start();

$controller = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['password'])) {
        if ($_SERVER['REQUEST_URI'] === '/signup') {
            if ($controller->signup($_POST['username'], $_POST['password'])) {
                echo "Signup successful!";
            } else {
                echo "Username already exists!";
            }
        } elseif ($_SERVER['REQUEST_URI'] === '/login') {
            if ($controller->login($_POST['username'], $_POST['password'])) {
                echo "Login successful!";
            } else {
                echo "Login failed!";
            }
        }
    } elseif (isset($_POST['username'], $_POST['newPassword']) && $_SERVER['REQUEST_URI'] === '/forgot-password') {
        if ($controller->forgotPassword($_POST['username'], $_POST['newPassword'])) {
            echo "Password reset successful!";
        } else {
            echo "User not found!";
        }
    }
} else {
    if ($_SERVER['REQUEST_URI'] === '/signup') {
        require '../app/Views/auth/signup.php';
    } elseif ($_SERVER['REQUEST_URI'] === '/forgot-password') {
        require '../app/Views/auth/forgot_password.php';
    } else {
        require '../app/Views/auth/login.php';
    }
}
