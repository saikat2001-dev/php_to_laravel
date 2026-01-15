<?php
// Determine if we are in Edit mode or Create mode
$isEdit = isset($product);
$title = $isEdit ? "Edit Product: " . htmlspecialchars($product['name']) : "Add New Product";
$action = $isEdit ? "/product/update" : "/product/create";
?>

<?php include __DIR__ . '/../partials/header.php'; ?>

<main class="container" style="max-width: 800px; margin: 3rem auto;">
    <div class="product-card" style="padding: 2.5rem;">
        <h2 style="margin-bottom: 1.5rem;"><?= $title ?></h2>

        <form action="<?= $action ?>" method="POST" enctype="multipart/form-data"
            style="display: flex; flex-direction: column; gap: 1.5rem;">

            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label style="display:block; margin-bottom:0.5rem;">Product Name</label>
                <input type="text" name="name" required
                    value="<?= $isEdit ? htmlspecialchars($product['name']) : '' ?>"
                    placeholder="e.g. Leather Boots"
                    style="width:100%; padding:0.8rem; border:1px solid #ddd; border-radius:8px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem;">Price ($)</label>
                    <input type="number" name="price" step="0.01" required
                        value="<?= $isEdit ? $product['price'] : '' ?>"
                        placeholder="0.00"
                        style="width:100%; padding:0.8rem; border:1px solid #ddd; border-radius:8px;">
                </div>
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem;">Category</label>
                    <select name="category_id" style="width:100%; padding:0.8rem; border:1px solid #ddd; border-radius:8px;">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($isEdit && $product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:0.5rem;">Product Image</label>
                <?php if ($isEdit && $product['image']): ?>
                    <div style="margin-bottom: 10px;">
                        <img src="/assets/photos/<?= $product['image'] ?>" alt="Current" style="height: 60px; border-radius: 4px; border: 1px solid #eee;">
                        <p style="font-size: 0.75rem; color: #666;">Leave empty to keep current image</p>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" accept="image/*" style="width:100%; padding:0.6rem;">
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:0.5rem;">Description</label>
                <textarea name="description" rows="5" placeholder="Describe the product features..."
                    style="width:100%; padding:0.8rem; border:1px solid #ddd; border-radius:8px; resize: vertical;"><?= $isEdit ? htmlspecialchars($product['description']) : '' ?></textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button type="submit" class="btn-primary"
                    style="flex: 2; padding: 1rem; border: none; cursor: pointer; border-radius: 8px;">
                    <?= $isEdit ? 'Update Product' : 'Save Product' ?>
                </button>
                <a href="/shop"
                    style="flex: 1; text-align: center; padding: 1rem; background: #eee; color: #333; text-decoration: none; border-radius: 8px;">Cancel</a>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>