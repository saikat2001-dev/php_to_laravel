<?php
// Determine if we are in Edit mode or Create mode
$isEdit = isset($product);
$title = $isEdit ? "Edit Product" : "Add New Product";
$subtitle = $isEdit ? "Update details for " . htmlspecialchars($product['name']) : "Fill in the information below to list a new item.";
$action = $isEdit ? "/product/update" : "/product/create";
?>

<?php include __DIR__ . '/../partials/header.php'; ?>


<main class="container" style="max-width: 850px; margin: 4rem auto;">
    <div style="background: #ffffff; padding: 3rem; border-radius: 16px; border: 1px solid #f0f0f0;">

        <div style="margin-bottom: 2.5rem; padding-bottom: 1.5rem;">
            <h2 style="margin: 0; font-size: 1.75rem; color: #1a1a1a; font-weight: 600;"><?= $title ?></h2>
            <p style="margin: 0.5rem 0 0; color: #666; font-size: 0.95rem;"><?= $subtitle ?></p>
        </div>

        <form action="<?= $action ?>" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 2rem;">

            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label style="display:block; margin-bottom:0.6rem; font-weight: 500; color: #444; font-size: 0.9rem;">Product Name</label>
                <input type="text" name="name" required
                    value="<?= $isEdit ? htmlspecialchars($product['name']) : '' ?>"
                    placeholder="e.g. Leather Boots"
                    style="width:100%; padding:0.9rem 1rem; border:1px solid #e0e0e0; border-radius:10px; font-size: 1rem; transition: border-color 0.2s; outline: none; width: -webkit-fill-available;"
                    onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='#e0e0e0'">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1.5fr; gap: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.6rem; font-weight: 500; color: #444; font-size: 0.9rem;">Price (₹)</label>
                    <input type="number" name="price" step="0.01" required
                        value="<?= $isEdit ? $product['price'] : '' ?>"
                        placeholder="0.00"
                        style="padding:0.9rem 1rem; border:1px solid #e0e0e0; border-radius:10px; font-size: 1rem; outline: none;"
                        onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='#e0e0e0'">
                </div>

                <div class="form-group">
                    <label style="display:block; margin-bottom:0.6rem; font-weight: 500; color: #444; font-size: 0.9rem;">Stock Level</label>
                    <input type="number" name="stock" min="0" required
                        value="<?= isset($product) ? $product['stock'] : '10' ?>"
                        style="padding:0.9rem 1rem; border:1px solid #e0e0e0; border-radius:10px; font-size: 1rem; outline: none;"
                        onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='#e0e0e0'">
                </div>

                <div class="form-group">
                    <label style="display:block; margin-bottom:0.6rem; font-weight: 500; color: #444; font-size: 0.9rem;">Category</label>
                    <select name="category_id" style="padding:0.9rem 1rem; border:1px solid #e0e0e0; border-radius:10px; font-size: 1rem; background: #fff; outline: none; appearance: none; cursor: pointer; width: -webkit-fill-available"
                        onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='#e0e0e0'">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($isEdit && $product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group" style="background: #fcfcfc; padding: 1.5rem; border-radius: 12px; border: 1px dashed #dcdcdc;">
                <label style="display:block; margin-bottom:0.8rem; font-weight: 500; color: #444; font-size: 0.9rem;">Product Image</label>

                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <?php if ($isEdit && $product['image']): ?>
                        <div style="position: relative;">
                            <img src="/assets/photos/<?= $product['image'] ?>" alt="Current" style="height: 80px; width: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                        </div>
                    <?php endif; ?>

                    <div style="flex: 1;">
                        <input type="file" name="image" accept="image/*" style="font-size: 0.9rem; color: #666;">
                        <p style="margin: 0.5rem 0 0; font-size: 0.75rem; color: #888;">
                            <?= $isEdit ? "Recommended size: 800x800px. Leave empty to keep current." : "Upload a high-quality JPG or PNG." ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:0.6rem; font-weight: 500; color: #444; font-size: 0.9rem;">Description</label>
                <textarea name="description" rows="5" placeholder="Briefly describe what makes this product great..."
                    style="width:-webkit-fill-available; padding:1rem; border:1px solid #e0e0e0; border-radius:10px; font-size: 1rem; line-height: 1.5; resize: vertical; outline: none;"
                    onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='#e0e0e0'"><?= $isEdit ? htmlspecialchars($product['description']) : '' ?></textarea>
            </div>

            <div style="display: flex; gap: 1.2rem; margin-top: 1rem; align-items: center;">
                <button type="submit" class="btn-primary"
                    style="flex: 2; padding: 1.1rem; border: none; cursor: pointer; border-radius: 10px; font-weight: 600; font-size: 1rem; transition: transform 0.1s, opacity 0.2s;"
                    onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'" onmousedown="this.style.transform='scale(0.98)'" onmouseup="this.style.transform='scale(1)'">
                    <?= $isEdit ? 'Update Changes' : 'Create Product' ?>
                </button>
                <a href="/shop"
                    style="flex: 1; text-align: center; padding: 1.1rem; background: #f5f5f5; color: #666; text-decoration: none; border-radius: 10px; font-weight: 500; font-size: 1rem; transition: background 0.2s;"
                    onmouseover="this.style.background='#ebebeb'" onmouseout="this.style.background='#f5f5f5'">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>