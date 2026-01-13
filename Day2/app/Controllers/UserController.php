<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
  public function register()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = trim($_POST['name']);
      $email = trim($_POST['email']);
      $password = $_POST['password'];
      $confirmPassword = $_POST['confirm_password'];
      $roleId = $_POST['roleId'];

      if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
      } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
      } else {
        $success = User::registerUser($name, $email, $password, $roleId);

        if ($success) {
          header('Location: /?route=/login&registered=success');
          exit();
        } else {
          $error = "Registration failed. Email migt already be taken.";
          include __DIR__ . '/../../resources/views/auth/register.php';
        }
      }
    }
    include __DIR__ . '/../../resources/views/auth/register.php';
  }
}