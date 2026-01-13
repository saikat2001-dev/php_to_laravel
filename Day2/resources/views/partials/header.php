<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?? 'E Commerce' ?></title>
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
        <a href="/" class="logo"><?= $companyName ?>.</a>
        <div class="nav-links">
          <a href="/shop.php">Shop</a>
          <a href="/categories.php">Categories</a>
          <a href="/cart.php">Cart (0)</a>
        </div>
      </nav>
    </div>
  </header>