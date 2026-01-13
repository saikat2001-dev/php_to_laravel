<?php include 'partials/header.php'; ?>

<section class="hero">
    <div class="container">
        <h1>Premium Quality, <br>Delivered to You.</h1>
        <p>Discover our curated collection of modern essentials.</p>
        <br>
        <a href="#products" class="btn-primary">Shop Collection</a>
    </div>
</section>
<main class="container" id="products">
    <h2 style="margin-top: 3rem;">Featured Products</h2>
    <div class="product-grid">

        <?php if (!empty($products)): ?>
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="product-img">
                    <div class="product-info">
                        <h3><?= htmlspecialchars($p['name']) ?></h3>
                        <p class="product-price">$<?= number_format($p['price'], 2) ?></p>
                        <a href="/product.php?id=<?= $p['id'] ?>" class="btn-primary"
                            style="width: 100%; text-align: center; margin-top: 1rem;">View Product</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-products" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                <p>No products to show at the moment. Please check back later!</p>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php include 'partials/footer.php'; ?>