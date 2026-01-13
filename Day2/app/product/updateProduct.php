<?php

session_start();
$pdo = require '../../connectDB.php';

if (!isset($_GET["id"]) || !is_numeric($_GET['id'])) {
  header('Localtion: ../home/home.php');
  exit;
}
$productId = $_GET['id'];

$fetchProductQry = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$fetchProductQry->execute([$productId]);
$product = $fetchProductQry->fetch(PDO::FETCH_ASSOC);

if (!$product) {
  $_SESSION['msg'] = "Product not found";
  $_SESSION['msg_type'] = "error";
  header('Location: ../home/home.php');
  exit;
}

$categories = $pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $productName = trim($_POST['productName']);
  $productPrice = $_POST['productPrice'];
  $categoryId = $_POST['categoryId'];

  if ($productName && is_numeric($productPrice) && $categoryId) {
    $updateProductQry = $pdo->prepare('UPDATE products SET name = ?, price = ?, category_id = ? where id = ?');

    $updateProductQry->execute([$productName, $productPrice, $categoryId, $productId]);

    $_SESSION['msg'] = "Product updated successfully";
    $_SESSION['msg_type'] = "success";
    header('Location: ../home/home.php');
    exit;
  } else {
    $error = "All fields are required";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Update Product</title>
</head>

<body>
  <h2>Update Product '<?php echo $product['name']; ?>'</h2>

  <?php if (!empty($error)): ?>
    <div class="msg error"><?= $error; ?></div>
  <?php endif; ?>

  <form method="post" class="add-form">
    <input type="text" name="productName" value="<?= htmlspecialchars($product['name']); ?>" required>

    <input type="number" name="productPrice" step="0.01" min="0" value="<?= $product['price']; ?>" required>

    <select name="categoryId" required>
      <option value="">-- Select Category --</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['id']; ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : ''; ?>>
          <?= htmlspecialchars($cat['name']); ?>
        </option>
      <?php endforeach; ?>
    </select>

    <button type="submit">Update Product</button>
    <a href="../home/home.php" class="btn-cancel">Cancel</a>
  </form>
</body>

</html>