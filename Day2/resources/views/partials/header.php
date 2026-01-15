<?php
// 1. Dynamic Title Logic
$current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$titles = [
  '/' => 'Home',
  '/login' => 'Login',
  '/register' => 'Create Account',
  '/dashboard' => 'Admin Dashboard',
  '/shop' => 'Shop All Products',
  '/cart' => 'Your Shopping Cart'
];

$page_label = $titles[$current_path] ?? ucfirst(ltrim($current_path, '/'));
$display_title = COMPANY_NAME . " | " . ($page_label ?: 'E Commerce');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $display_title ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <header>
    <div class="container">
      <nav>
        <a href="/" class="logo"><?= COMPANY_NAME ?>.</a>
        <div class="nav-links">
          <a href="/shop">Shop</a>
          <a href="/categories">Categories</a>

          <a href="/cart">Cart (
          <?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>  
          )</a>
          <?php if (isset($_SESSION['userId'])): ?>

            <?php if ($_SESSION['roleId'] == "1"): // Assuming 1 is Admin ?>
              <a href="/dashboard" style="font-weight: bold; color: #3498db;">Dashboard</a>
            <?php endif; ?>

            <a href="/logout">Logout</a>
          <?php else: ?>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
          <?php endif; ?>
        </div>
      </nav>
    </div>
  </header>