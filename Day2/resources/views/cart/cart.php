<?php include __DIR__ . '/../partials/header.php' ?>

<main class="container" style="padding: 3rem 0; max-width: 950px;">
  <h1 style="margin-bottom: 2rem;">Your Shopping Cart</h1>

  <?php if (!empty($products)): ?>
    <div style="background: #fff; border: 1px solid #eee; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
      <?php $total = 0; ?>
      <?php foreach ($products as $product): ?>
        <?php 
          // Get quantity from the associative session array [id => qty]
          $qty = $_SESSION['cart'][$product['id']] ?? 1;
          $subtotal = $product['price'] * $qty;
          $total += $subtotal;
        ?>
        <div style="display: flex; align-items: center; padding: 1.5rem; border-bottom: 1px solid #eee; gap: 1.5rem;">
          
          <div style="width: 100px; height: 100px; background: #f8fafc; border-radius: 8px; overflow: hidden; border: 1px solid #f1f5f9;">
            <img src="/assets/photos/<?= $product['image'] ?>" style="width:100%; height:100%; object-fit: cover;">
          </div>

          <div style="flex: 1;">
            <h3 style="margin: 0; font-size: 1.1rem;"><?= htmlspecialchars($product['name']) ?></h3>
            <p style="color: #64748b; font-size: 0.85rem; margin: 4px 0;">Unit Price: ₹<?= number_format($product['price'], 2) ?></p>
            <p style="color: <?= $product['stock'] < 5 ? '#f59e0b' : '#94a3b8' ?>; font-size: 0.75rem; margin: 0;">
              Stock Available: <?= $product['stock'] ?>
            </p>
          </div>

          <div style="display: flex; align-items: center; background: #f1f5f9; border-radius: 25px; padding: 4px 12px; border: 1px solid #e2e8f0;">
            <form action="/cart/update-quantity" method="POST" style="margin:0;">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="action" value="dec">
                <button type="submit" 
                        style="border:none; background:none; cursor:pointer; font-size: 1.2rem; padding: 0 8px; color: #64748b;"
                        <?= $qty <= 1 ? 'disabled style="opacity:0.3; cursor:not-allowed;"' : '' ?>>
                  -
                </button>
            </form>

            <span style="font-weight: 700; min-width: 30px; text-align: center; font-size: 1rem; color: #1e293b;">
              <?= $qty ?>
            </span>

            <form action="/cart/update-quantity" method="POST" style="margin:0;">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="action" value="inc">
                <button type="submit" 
                        style="border:none; background:none; cursor:pointer; font-size: 1.2rem; padding: 0 8px; color: #64748b;"
                        <?= $qty >= $product['stock'] ? 'disabled style="opacity:0.3; cursor:not-allowed;"' : '' ?>>
                  +
                </button>
            </form>
          </div>

          <div style="font-weight: 700; font-size: 1.1rem; width: 120px; text-align: right; color: var(--dark);">
            ₹<?= number_format($subtotal, 2) ?>
          </div>

          <form action="/cart/remove" method="POST" style="margin:0;">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 5px;" title="Remove Item">
              &times;
            </button>
          </form>
        </div>
      <?php endforeach; ?>

      <div style="padding: 2rem; background: #f8fafc; display: flex; justify-content: space-between; align-items: center; border-top: 2px solid #f1f5f9;">
        <div>
          <span style="color: #64748b; font-weight: 500;">Grand Total:</span>
          <h2 style="margin: 0; color: var(--primary); font-size: 2rem;">₹<?= number_format($total, 2) ?></h2>
        </div>
        <div style="display: flex; gap: 1rem;">
          <a href="/shop" style="text-decoration: none; color: #64748b; padding: 1rem; font-size: 0.9rem; align-self: center;">Continue Shopping</a>
          <a href="/checkout/create-session" class="btn-primary" style="padding: 1rem 2.5rem; text-decoration: none; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
            Proceed to Checkout
          </a>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div style="text-align: center; padding: 5rem 2rem; background: #f9fafb; border-radius: 12px; border: 1px dashed #cbd5e1;">
      <div style="font-size: 3rem; margin-bottom: 1rem;">🛒</div>
      <p style="color: #64748b; font-size: 1.2rem; margin-bottom: 2rem;">Your cart is empty.</p>
      <a href="/shop" class="btn-primary" style="padding: 1rem 2rem; text-decoration: none; border-radius: 8px; font-weight: 600;">Explore Shop</a>
    </div>
  <?php endif; ?>
</main>

<?php include __DIR__ . '/../partials/footer.php' ?>