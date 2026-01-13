<?php
// Get the current path
$current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Create a mapping of routes to clean titles
$titles = [
  '/' => 'Home',
  '/login' => 'Login',
  '/register' => 'Create Account',
  '/dashboard' => 'Admin Dashboard'
];

$page_label = $titles[$current_path] ?? ucfirst(ltrim($current_path, '/'));
$display_title = COMPANY_NAME ." | " . ($page_label ?: 'Modern Essentials');
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
          <a href="/shop.php">Shop</a>
          <a href="/categories.php">Categories</a>
          <a href="/cart.php">Cart (0)</a>
        </div>
      </nav>
    </div>
  </header>