<?php include __DIR__ . '/../../partials/header.php'; ?>

<main class="container" style="max-width: 800px; margin: 3rem auto;">
    <div class="product-card" style="padding: 2.5rem;">
        <h2 style="margin-bottom: 1.5rem;">Add New Product</h2>

        <form action="/product/create" method="POST" enctype="multipart/form-data"
            style="display: flex; flex-direction: column; gap: 1.5rem;">

            <div class="form-group">
                <label style="display:block; margin-bottom:0.5rem;">Product Name</label>
                <input type="text" name="name" required placeholder="e.g. Leather Boots"
                    style="width:100%; padding:0.8rem; border:1px solid #ddd; border-radius:8px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem;">Price (₹)</label>
                    <input type="number" name="price" step="0.01" required placeholder="0.00"
                        style="width:100%; padding:0.8rem; border:1px solid #ddd; border-radius:8px;">
                </div>
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem;">Product Image</label>
                    <input type="file" name="image" accept="image/*" style="width:100%; padding:0.6rem;">
                </div>
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:0.5rem;">Description</label>
                <textarea name="description" rows="5" placeholder="Describe the product features..."
                    style="width:100%; padding:0.8rem; border:1px solid #ddd; border-radius:8px; resize: vertical;"></textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button type="submit" class="btn-primary"
                    style="flex: 2; padding: 1rem; border: none; cursor: pointer;">Save Product</button>
                <a href="/shop"
                    style="flex: 1; text-align: center; padding: 1rem; background: #eee; color: #333; text-decoration: none; border-radius: 8px;">Cancel</a>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../../partials/footer.php'; ?>