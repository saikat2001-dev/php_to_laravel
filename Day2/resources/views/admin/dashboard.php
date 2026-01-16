<?php include __DIR__ . '/../partials/header.php'; ?>

<main class="admin-container" style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem;">

  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
    <div>
      <h1 style="margin: 0; font-size: 1.75rem; color: #1e293b;">Business Overview</h1>
      <p style="color: #64748b; margin-top: 0.25rem;">Real-time performance metrics</p>
    </div>

    <form method="GET" action="/admin/dashboard" style="display: flex; gap: 0.5rem;">
      <select name="status" onchange="this.form.submit()" style="padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid #e2e8f0; background: #fff; cursor: pointer;">
        <option value="all" <?= ($filter == 'all') ? 'selected' : '' ?>>All Time</option>
        <option value="completed" <?= ($filter == 'completed') ? 'selected' : '' ?>>Completed</option>
        <option value="pending" <?= ($filter == 'pending') ? 'selected' : '' ?>>Pending</option>
      </select>
    </form>
</div>

  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">

    <div style="background: #fff; padding: 1.5rem; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
      <span style="color: #64748b; font-size: 0.875rem; font-weight: 500;">Total Revenue</span>
      <div style="font-size: 1.8rem; font-weight: 700; color: #0f172a; margin-top: 0.5rem;">₹<?= number_format($revenue, 2); ?></div>
      <div style="color: #10b981; font-size: 0.8rem; margin-top: 0.5rem;">↑ 12% from last month</div>
    </div>

    <div style="background: #fff; padding: 1.5rem; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
      <span style="color: #64748b; font-size: 0.875rem; font-weight: 500;">Items Sold</span>
      <div style="font-size: 1.8rem; font-weight: 700; color: #0f172a; margin-top: 0.5rem;"><?= $productsSold ?></div>
      <div style="color: #64748b; font-size: 0.8rem; margin-top: 0.5rem;">Total units shipped</div>
    </div>

    <div style="background: #fff; padding: 1.5rem; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
      <span style="color: #64748b; font-size: 0.875rem; font-weight: 500;">Total Customers</span>
      <div style="font-size: 1.8rem; font-weight: 700; color: #0f172a; margin-top: 0.5rem;"><?= $customerCount ?></div>
      <div style="color: #10b981; font-size: 0.8rem; margin-top: 0.5rem;">Active accounts</div>
    </div>

  </div>

  <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">

    <section style="background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden;">
      <div style="padding: 1.25rem; border-bottom: 1px solid #e2e8f0; font-weight: 600; color: #1e293b;">Recent Orders</div>
      <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
          <thead>
            <tr style="background: #f8fafc; color: #64748b; font-size: 0.8rem; text-transform: uppercase;">
              <th style="padding: 1rem;">Order ID</th>
              <th style="padding: 1rem;">Customer</th>
              <th style="padding: 1rem;">Amount</th>
              <th style="padding: 1rem;">Status</th>
            </tr>
          </thead>
          <tbody style="color: #334155; font-size: 0.95rem;">
            <?php foreach ($recentOrders as $order): ?>
              <tr style="border-bottom: 1px solid #f1f5f9;">
                <td style="padding: 1rem;">#<?= $order['id'] ?></td>
                <td style="padding: 1rem;"><?= htmlspecialchars($order['customer_name'] ?? 'Guest') ?></td>
                <td style="padding: 1rem;">₹<?= number_format($order['total_amount'], 2) ?></td>
                <td style="padding: 1rem;">
                  <span style="background: #f0fdf4; color: #16a34a; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                    <?= strtoupper($order['status']) ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

    <section style="background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 1.25rem;">
      <h3 style="margin-top: 0; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.5rem;">Top Buyers</h3>
      <div style="display: flex; flex-direction: column; gap: 1rem;">
        <?php foreach ($topBuyers as $buyer): ?>
          <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid #f1f5f9;">
            <div>
              <div style="font-weight: 600; color: #334155; font-size: 0.9rem;"><?= htmlspecialchars($buyer['name']) ?></div>
              <div style="font-size: 0.75rem; color: #94a3b8;"><?= $buyer['order_count'] ?> Orders</div>
            </div>
            <div style="font-weight: 700; color: #1e293b; font-size: 0.9rem;">₹<?= number_format($buyer['total_spent'], 2) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

  </div>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>