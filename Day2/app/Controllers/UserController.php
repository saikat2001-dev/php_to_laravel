<?php

namespace App\Controllers;

use App\Models\Cart;
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
          header('Location: /login');
          exit();
        } else {
          $error = "Registration failed. Email might already be taken.";
        }
      }
    }
    include __DIR__ . '/../../resources/views/auth/register.php';
  }
  public function login()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'];
      $password = $_POST['password'];
      if (empty($email) || empty($password)) {
        $error = "All fields are required";
      } else {
        $userData = User::loginUser($email, $password);
        if ($userData) {
          $_SESSION['userId'] = $userData['id'];
          $_SESSION['roleId'] = $userData['roleId'];
          $_SESSION['permissions'] = $userData['permissions'];
          if(!empty($_SESSION['cart'])) {
            Cart::syncSessionCartToDb($userData['id'], $_SESSION['cart']);
          }
          $_SESSION['cart'] = Cart::getDbCartIds($userData['id']);
          $redirect = $_GET['redirect_to'];
          header("Location: /$redirect");
          exit;
        } else {
          $error = "Login failed. Password or email maybe invalid";
        }
      }
    }
    include __DIR__ . '/../../resources/views/auth/login.php';
  }
  public function logout() {
    $_SESSION = [];

    session_destroy();
    header('Location: /login?message=logged_out');
    exit;
  }
}