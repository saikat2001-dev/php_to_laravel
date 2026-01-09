<?php
session_start();
$pdo = require '../../connectDB.php';

// Fetch Categories for the dropdown
$categories = $pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_ASSOC);

// Fetch Products with Category Name using a JOIN
$sql = "SELECT p.*, c.name AS category_name 
        FROM products p 
        LEFT JOIN category c ON p.category_id = c.id 
        ORDER BY p.created_at DESC";
$products = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Product Management</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <h2>Add New Product</h2>

  <?php if (isset($_SESSION['msg'])): ?>
    <div class="msg <?= $_SESSION['msg_type']; ?>">
      <?= $_SESSION['msg'];
      unset($_SESSION['msg'], $_SESSION['msg_type']); ?>
    </div>
  <?php endif; ?>

  <form method="post" action="../product/addProduct.php" class="add-form">
    <input type="text" name="productName" placeholder="Product Name" required>
    <input type="number" name="productPrice" step="0.01" min="0" placeholder="Price" required>
    <select name="categoryId" required>
      <option value="">-- Select Category --</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['id']; ?>"><?= htmlspecialchars($cat['name']); ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit">Add Product</button>
  </form>

  <hr>

  <h2>Existing Products</h2>

  <form method="post" action="../product/bulkAction.php" id="bulkForm">
    <div style="margin-bottom: 10px;">
      <button type="submit" name="action" value="bulk_delete" onclick="return confirm('Delete selected products?')"
        class="bulk-del-btn">
        Delete Selected
      </button>
    </div>

    <table>
      <thead>
        <tr>
          <th><input type="checkbox" id="selectAll"></th>
          <th>ID</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($products): ?>
          <?php foreach ($products as $p): ?>
            <tr class="product-row">
              <td><input type="checkbox" name="ids[]" value="<?= $p['id']; ?>"></td>
              <td><?= $p['id']; ?></td>
              <td><?= htmlspecialchars($p['name']); ?></td>
              <td><?= htmlspecialchars($p['category_name'] ?? 'Uncategorized'); ?></td>
              <td>$<?= number_format($p['price'], 2); ?></td>
              <td class="action-cell">
                <div class="hover-actions">
                  <a href="editProduct.php?id=<?= $p['id']; ?>" class="btn-edit">Edit</a>
                  <a href="../product/deleteProduct.php?id=<?= $p['id']; ?>" class="btn-delete"
                    onclick="return confirm('Delete this product?')">Delete</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6">No products found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </form>

  <script>
    // Simple JS to toggle all checkboxes
    document.getElementById('selectAll').onclick = function () {
      var checkboxes = document.getElementsByName('ids[]');
      for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
      }
    }
  </script>
</body>

</html>