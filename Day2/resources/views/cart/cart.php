<?php include __DIR__ . '/../partials/header.php' ?>

<main class="container" style="padding: 3rem 0; max-width: 900px;">
  <h1 style="margin-bottom: 2rem;">Your Shopping Cart</h1>

  <?php if (!empty($products)): ?>
    <div style="background: #fff; border: 1px solid #eee; border-radius: 12px; overflow: hidden;">
      <?php $total = 0; ?>
      <?php foreach ($products as $product): ?>
        <?php $total += $product['price']; ?>
        <div style="display: flex; align-items: center; padding: 1.5rem; border-bottom: 1px solid #eee; gap: 1.5rem;">
          <div style="width: 100px; height: 100px; background: #f8fafc; border-radius: 8px; overflow: hidden;">
            <img src="/assets/photos/<?= $product['image'] ?>" style="width:100%; height:100%; object-fit: cover;">
          </div>

          <div style="flex: 1;">
            <h3 style="margin: 0;"><?= htmlspecialchars($product['name']) ?></h3>
            <p style="color: #64748b; font-size: 0.9rem; margin: 5px 0;">Product ID: #<?= $product['id'] ?></p>
          </div>

          <div style="font-weight: 700; font-size: 1.1rem;">
            ₹<?= number_format($product['price'], 2) ?>
          </div>

          <form action="/cart/remove" method="POST">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.85rem;">Remove</button>
          </form>
        </div>
      <?php endforeach; ?>

      <div style="padding: 2rem; background: #f8fafc; display: flex; justify-content: space-between; align-items: center;">
        <div>
          <span style="color: #64748b;">Total Amount:</span>
          <h2 style="margin: 0; color: var(--primary);">₹<?= number_format($total, 2) ?></h2>
        </div>
        <a href="/checkout" class="btn-primary" style="padding: 1rem 2rem; text-decoration: none; border-radius: 8px; font-weight: 600;">
          Proceed to Checkout
        </a>
      </div>
    </div>
  <?php else: ?>
    <div style="text-align: center; padding: 4rem; background: #f9fafb; border-radius: 12px;">
      <p style="color: #666; font-size: 1.1rem; margin-bottom: 1.5rem;">Your cart is empty.</p>
      <a href="/shop" class="btn-primary" style="padding: 0.8rem 1.5rem; text-decoration: none; border-radius: 8px;">Go to Shop</a>
    </div>
  <?php endif; ?>
</main>

<?php include __DIR__ . '/../partials/footer.php' ?>