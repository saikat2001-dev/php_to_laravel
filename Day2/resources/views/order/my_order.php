<?php include __DIR__ . '/../partials/header.php'; ?>

<main class="container" style="max-width: 900px; margin: 4rem auto; font-family: 'Inter', sans-serif;">
    <h2 style="margin-bottom: 2rem; color: #1a1a1a;">Your Purchase History</h2>

    <?php if (empty($orders)): ?>
        <div style="text-align: center; padding: 4rem; background: #f8fafc; border-radius: 16px;">
            <p style="color: #64748b;">You haven't placed any orders yet.</p>
            <a href="/shop" class="btn-primary" style="display: inline-block; margin-top: 1rem; text-decoration: none; padding: 0.8rem 2rem; border-radius: 8px;">Start Shopping</a>
        </div>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <?php foreach ($orders as $orderId => $order): ?>
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                    <div style="background: #f8fafc; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0;">
                        <div>
                            <span style="font-size: 0.85rem; color: #64748b; text-transform: uppercase;">Order #<?= $orderId ?></span>
                            <div style="font-size: 0.9rem; color: #1e293b; font-weight: 500;"><?= date('M d, Y', strtotime($order['info']['date'])) ?></div>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 0.85rem; color: #64748b; text-transform: uppercase;">Total Paid</span>
                            <div style="font-size: 1.1rem; color: #16a34a; font-weight: 700;">₹<?= number_format($order['info']['total'], 2) ?></div>
                        </div>
                    </div>

                    <div style="padding: 1.5rem;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <?php foreach ($order['items'] as $item): ?>
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 0.75rem 0; color: #1e293b; font-weight: 500;"><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td style="padding: 0.75rem 0; color: #64748b; text-align: center;">Qty: <?= $item['quantity'] ?></td>
                                    <td style="padding: 0.75rem 0; color: #1e293b; text-align: right;">₹<?= number_format($item['price_at_purchase'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <div style="margin-top: 1rem; display: flex; justify-content: flex-end;">
                            <span style="background: #f0fdf4; color: #16a34a; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">
                                <?= $order['info']['status'] ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>