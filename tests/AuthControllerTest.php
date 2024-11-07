<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\AuthController;

class AuthControllerTest extends TestCase
{
    protected $authController;

    protected function setUp(): void
    {
        $this->authController = new AuthController();
    }

    public function testLoginSuccess()
    {
        $username = 'testuser';
        $password = 'testpassword';
        $result = $this->authController->login($username, $password);
        $this->assertTrue($result, "Login should succeed with correct credentials.");
    }

    public function testLoginFailureWithIncorrectPassword()
    {
        $username = 'testuser';
        $password = 'wrongpassword';
        $result = $this->authController->login($username, $password);
        $this->assertFalse($result, "Login should fail with incorrect password.");
    }

    public function testLoginFailureWithNonexistentUser()
    {
        $username = 'nonexistentuser';
        $password = 'anyPassword';
        $result = $this->authController->login($username, $password);
        $this->assertFalse($result, "Login should fail for nonexistent user.");
    }

    public function testSignupSuccess()
    {
        $username = 'newuser';
        $password = 'newpassword';
        $result = $this->authController->signup($username, $password);
        $this->assertTrue($result, "Signup should succeed for new user.");
    }

    public function testSignupFailureForExistingUser()
    {
        $username = 'testuser';
        $password = 'anotherpassword';
        $result = $this->authController->signup($username, $password);
        $this->assertFalse($result, "Signup should fail for existing username.");
    }

    public function testForgotPasswordSuccess()
    {
        $username = 'testuser';
        $newPassword = 'newtestpassword';
        $result = $this->authController->forgotPassword($username, $newPassword);
        $this->assertTrue($result, "Forgot password should succeed for existing user.");
    }

    public function testForgotPasswordFailureForNonexistentUser()
    {
        $username = 'nonexistentuser';
        $newPassword = 'newpassword';
        $result = $this->authController->forgotPassword($username, $newPassword);
        $this->assertFalse($result, "Forgot password should fail for nonexistent user.");
    }
}
