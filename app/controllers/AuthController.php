<?php
namespace App\Controllers;

use App\Models\UserModel;

class AuthController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login($username, $password)
    {
        $user = $this->userModel->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return true; // Login berhasil
        }

        return false; // Login gagal
    }

    public function signup($username, $password)
    {
        if ($this->userModel->getUserByUsername($username)) {
            return false; // Username sudah ada
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->userModel->createUser($username, $hashedPassword);
    }

    public function forgotPassword($username, $newPassword)
    {
        $user = $this->userModel->getUserByUsername($username);

        if (!$user) {
            return false; // Pengguna tidak ditemukan
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->userModel->updatePassword($username, $hashedPassword);
    }
}
