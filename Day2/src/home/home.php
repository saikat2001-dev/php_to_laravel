<?php
$pdo = require '../../connectDB.php';
$qryToFetchCategory = $pdo->prepare('SELECT * FROM category');
if ($qryToFetchCategory->execute()) {
  // echo "Category fetched successfully";
  $categories = $qryToFetchCategory->fetchAll(PDO::FETCH_ASSOC);
} else {
  echo "Failed to fetch category";
}

$qryToFetchProduct = $pdo->prepare('SELECT p.*, c.name AS category_name FROM products p JOIN category c on p.category_id = c.id');
if ($qryToFetchProduct->execute()) {
  $products = $qryToFetchProduct->fetchAll(PDO::FETCH_ASSOC);
} else {
  echo "Failed to fetch products";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page | Products</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <form method="post" action="../product/addProduct.php">
    <input type="text" name="productName" id="" placeholder="Enter product name">
    <input type="number" name="productPrice" id="" min="0" max="100000" placeholder="Enter product price">
    <select name="categoryId" id="">
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['id']; ?>">
          <?= htmlspecialchars($cat['name']); ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit">Add Product</button>
  </form>
  <hr>
  <h2>Product List</h2>
  <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 20px; text-align: left;">
    <thead>
      <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Date Added</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
          <tr>
            <td><?= $product['id']; ?></td>
            <td><?= htmlspecialchars($product['name']); ?></td>
            <td><?= htmlspecialchars($product['category_name']); ?></td>
            <td>$<?= number_format($product['price'], 2); ?></td>
            <td><?= $product['created_at']; ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5">No products found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>

</html>