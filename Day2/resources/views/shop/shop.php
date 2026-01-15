<?php include __DIR__ . '/../partials/header.php' ?>

<main class="container" style="padding: 2rem 0;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
      <h1 style="font-size: 2rem; color: var(--dark);">All Products</h1>
      <p style="color: #666;">Discover our latest collection</p>
    </div>

    <?php if (isset($_SESSION['permissions']) && in_array('add_product', $_SESSION['permissions'])): ?>
      <a href="/product/create" class="btn-primary" style="padding: 0.8rem 1.5rem; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; border-radius: 8px;">
        <span>+</span> Add New Product
      </a>
    <?php endif; ?>
  </div>

  <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
    <?php if (!empty($products)): ?>
      <?php foreach ($products as $product): ?>
        <div class="product-card" style="position: relative; border: 1px solid #eee; border-radius: 12px; overflow: hidden; transition: transform 0.2s; background: #fff;">

          <?php if (isset($_SESSION['permissions']) && in_array('delete_product', $_SESSION['permissions'])): ?>
            <div class="admin-actions-overlay" style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle at top right, rgba(0,0,0,0.3) 0%, transparent 70%); display: flex; justify-content: flex-end; padding: 10px; gap: 10px; z-index: 10;">
              <a href="/product/update?id=<?= $product['id'] ?>" class="admin-btn" title="Edit">
                <svg width="18" height="18" fill="white" viewBox="0 0 640 640">
                  <path d="M505 122.9L517.1 135C526.5 144.4 526.5 159.6 517.1 168.9L488 198.1L441.9 152L471 122.9C480.4 113.5 495.6 113.5 504.9 122.9zM273.8 320.2L408 185.9L454.1 232L319.8 366.2C316.9 369.1 313.3 371.2 309.4 372.3L250.9 389L267.6 330.5C268.7 326.6 270.8 323 273.7 320.1zM437.1 89L239.8 286.2C231.1 294.9 224.8 305.6 221.5 317.3L192.9 417.3C190.5 425.7 192.8 434.7 199 440.9C205.2 447.1 214.2 449.4 222.6 447L322.6 418.4C334.4 415 345.1 408.7 353.7 400.1L551 202.9C579.1 174.8 579.1 129.2 551 101.1L538.9 89C510.8 60.9 465.2 60.9 437.1 89zM152 128C103.4 128 64 167.4 64 216L64 488C64 536.6 103.4 576 152 576L424 576C472.6 576 512 536.6 512 488L512 376C512 362.7 501.3 352 488 352C474.7 352 464 362.7 464 376L464 488C464 510.1 446.1 528 424 528L152 528C129.9 528 112 510.1 112 488L112 216C112 193.9 129.9 176 152 176L264 176C277.3 176 288 165.3 288 152C288 138.7 277.3 128 264 128L152 128z" />
                </svg>
              </a>
              <form action="/product/delete" method="POST" onsubmit="return confirm('Delete this product?');">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <button type="submit" style="background:none; border:none; cursor:pointer;" title="Delete">
                  <svg width="18" height="18" fill="white" viewBox="0 0 640 640">
                    <path d="M262.2 48C248.9 48 236.9 56.3 232.2 68.8L216 112L120 112C106.7 112 96 122.7 96 136C96 149.3 106.7 160 120 160L520 160C533.3 160 544 149.3 544 136C544 122.7 533.3 112 520 112L424 112L407.8 68.8C403.1 56.3 391.2 48 377.8 48L262.2 48zM128 208L128 512C128 547.3 156.7 576 192 576L448 576C483.3 576 512 547.3 512 512L512 208L464 208L464 512C464 520.8 456.8 528 448 528L192 528C183.2 528 176 520.8 176 512L176 208L128 208zM288 280C288 266.7 277.3 256 264 256C250.7 256 240 266.7 240 280L240 456C240 469.3 250.7 480 264 480C277.3 480 288 469.3 288 456L288 280zM400 280C400 266.7 389.3 256 376 256C362.7 256 352 266.7 352 280L352 456C352 469.3 362.7 480 376 480C389.3 480 400 469.3 400 456L400 280z" />
                  </svg>
                </button>
              </form>
            </div>
          <?php endif; ?>

          <div style="height: 200px; background: #f8fafc; display: flex; align-items: center; justify-content: center;">
            <?php if ($product['image'] && file_exists('assets/photos/' . $product['image'])): ?>
              <img src="/assets/photos/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; height: 100%; object-fit: contain;">
            <?php else: ?>
              <span style="color: #cbd5e1;">No Image</span>
            <?php endif; ?>
          </div>

          <div style="padding: 1.5rem;">
            <h3 style="margin: 0 0 0.5rem 0; font-size: 1.25rem;"><?= htmlspecialchars($product['name']) ?></h3>
            <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1rem;">
              <?= htmlspecialchars(substr($product['description'], 0, 80)) ?>...
            </p>

            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                ₹<?= number_format($product['price'], 2) ?>
              </span>

              <?php if (isset($_SESSION['cart']) && in_array($product['id'], $_SESSION['cart'])): ?>
                <div style="color: #22c55e; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 4px;">
                  <span>✓</span> Added
                </div>
              <?php else: ?>
                <form action="/cart/add" method="POST">
                  <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                  <button type="submit" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.9rem; border-radius: 6px;">
                    Add to Cart
                  </button>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No products found.</p>
    <?php endif; ?>
  </div>
</main>

<?php include __DIR__ . '/../partials/footer.php' ?>