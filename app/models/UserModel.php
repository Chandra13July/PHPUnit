<?php
namespace App\Models;

class UserModel
{
    private $users;

    public function __construct()
    {
        $this->users = [
            'testuser' => [
                'id' => 1,
                'username' => 'testuser',
                'password' => password_hash('testpassword', PASSWORD_DEFAULT)
            ],
        ];
    }

    public function getUserByUsername($username)
    {
        return $this->users[$username] ?? null;
    }

    public function createUser($username, $hashedPassword)
    {
        $newId = count($this->users) + 1;
        $this->users[$username] = [
            'id' => $newId,
            'username' => $username,
            'password' => $hashedPassword
        ];

        return true;
    }

    public function updatePassword($username, $hashedPassword)
    {
        if (isset($this->users[$username])) {
            $this->users[$username]['password'] = $hashedPassword;
            return true;
        }

        return false;
    }
}
