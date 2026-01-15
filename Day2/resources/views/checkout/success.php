<?php include __DIR__ . '/../partials/header.php' ?>

<main class="container" style="padding: 4rem 0; max-width: 600px; text-align: center;">
    <div style="width: 80px; height: 80px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; font-size: 2.5rem;">
        ✓
    </div>

    <h1 style="font-size: 2.25rem; color: #1e293b; margin-bottom: 1rem;">Payment Successful!</h1>
    <p style="color: #64748b; font-size: 1.1rem; line-height: 1.6; margin-bottom: 2.5rem;">
        Thank you for your purchase. Your order has been placed successfully and is currently being processed. 
        A confirmation email will be sent to you shortly.
    </p>

    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 2rem; margin-bottom: 3rem; text-align: left;">
        <h3 style="margin-top: 0; font-size: 1rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Order Information</h3>
        
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e2e8f0;">
            <span style="color: #64748b;">Status</span>
            <span style="color: #16a34a; font-weight: 600; background: #f0fdf4; padding: 2px 8px; border-radius: 4px; font-size: 0.85rem;">Paid</span>
        </div>

        <div style="display: flex; justify-content: space-between;">
            <span style="color: #64748b;">Transaction ID</span>
            <span style="color: #1e293b; font-family: monospace; font-size: 0.9rem;">
                <?= htmlspecialchars(substr($sessionId, -12)) ?>...
            </span>
        </div>
    </div>

    <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="/shop" class="btn-primary" style="padding: 1rem 2rem; text-decoration: none; border-radius: 8px; font-weight: 600;">
            Continue Shopping
        </a>
        <a href="/my-orders" style="padding: 1rem 2rem; text-decoration: none; color: #475569; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff;">
            View My Orders
        </a>
    </div>
</main>

<?php include __DIR__ . '/../partials/footer.php' ?>