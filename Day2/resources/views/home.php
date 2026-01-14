<?php include 'partials/header.php'; ?>

<section class="hero">
    <div class="container">
        <h1>Premium Quality, <br>Delivered to You.</h1>
        <p>Discover our curated collection of modern essentials.</p>
        <br>
        <a href="/shop" class="btn-primary" style="display: inline-block; padding: 1rem 2rem; background: var(--primary); color: white; border-radius: 8px; text-decoration: none;">Shop Collection</a>
    </div>
</section>

<main class="container" id="products">
    <h2 style="margin-top: 3rem; margin-bottom: 1.5rem;">Featured Products</h2>

    <div class="product-grid-home" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $p): ?>
                <div class="product-card-small" style="border: 1px solid #eee; border-radius: 12px; overflow: hidden; background: #fff; display: flex; flex-direction: column; height: 100%;">

                    <div style="height: 160px; width: 100%; background: #f9f9f9; display: flex; align-items: center; justify-content: center; overflow: hidden; border-bottom: 1px solid #f0f0f0;">
                        <?php if (!empty($p['image']) && file_exists('assets/photos/' . $p['image'])): ?>
                            <img src="assets/photos/<?= $p['image'] ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width: 100%; height: 100%; object-fit: contain; mix-blend-mode: multiply;">
                        <?php else: ?>
                            <div style="text-align: center; color: #999; font-size: 0.8rem;">No Image</div>
                        <?php endif; ?>
                    </div>

                    <div style="padding: 1rem; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between; gap: 0.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="font-size: 1rem; margin: 0; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 65%;">
                                <?= htmlspecialchars($p['name']) ?>
                            </h3>
                            <p style="font-weight: 700; color: var(--primary); margin: 0;">
                                $<?= number_format($p['price'], 2) ?>
                            </p>
                        </div>

                        <a href="/product.php?id=<?= $p['id'] ?>" style="display: block; width: 100%; padding: 0.6rem 0; background: var(--primary); color: white; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; text-align: center; box-sizing: border-box; transition: opacity 0.2s;">
                            View Details
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; background: #fdfdfd; border: 2px dashed #eee; border-radius: 12px;">
                <p style="color: #888;">No featured products available.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'partials/footer.php'; ?>