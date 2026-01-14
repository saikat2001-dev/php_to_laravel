<?php include __DIR__ . '/../partials/header.php' ?>

<main class="container" style="padding: 2rem 0;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
      <h1 style="font-size: 2rem; color: var(--dark);">All Products</h1>
      <p style="color: #666;">Discover our latest collection</p>
    </div>

    <?php if (isset($_SESSION['permissions']) && in_array('add_product', $_SESSION['permissions'])): ?>
      <a href="/product/create" class="btn-primary"
        style="padding: 0.8rem 1.5rem; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
        <span>+</span> Add New Product
      </a>
    <?php endif; ?>
  </div>

  <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
    <?php if (!empty($products)): ?>
      <?php foreach ($products as $product): ?>
        <div class="product-card"
          style="border: 1px solid #eee; border-radius: 12px; overflow: hidden; transition: transform 0.2s; background: #fff;">
          <div
            style="height: 200px; background: #f8fafc; display: flex; align-items: center; justify-content: center; color: #cbd5e1;">
            <?php if ($product['image']): ?>
              <img src="/assets/photos/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>"
                style="width: 100%; height: 100%; object-fit: contain; mix-blend-mode: multiply;">
            <?php else: ?>
              <span>No Image</span>
            <?php endif; ?>
          </div>

          <div style="padding: 1.5rem;">
            <h3 style="margin: 0 0 0.5rem 0; font-size: 1.25rem;"><?= htmlspecialchars($product['name']) ?></h3>
            <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.4;">
              <?= htmlspecialchars(substr($product['description'], 0, 80)) ?>...
            </p>

            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                $<?= number_format($product['price'], 2) ?>
              </span>

              <form action="/cart/add" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <button type="submit" class="btn-primary"
                  style="padding: 0.5rem 1rem; font-size: 0.9rem; cursor: pointer; border: none;">
                  Add to Cart
                </button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No products found.</p>
    <?php endif; ?>
  </div>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>