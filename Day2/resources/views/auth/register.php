<?php include __DIR__ . '/../partials/header.php'; ?>

<main class="container">
  <div class="auth-wrapper" style="max-width: 500px; margin: 4rem auto;">
    <div class="product-card" style="padding: 2.5rem;">
      <div style="text-align: center; margin-bottom: 2rem;">
        <h2 style="font-size: 2rem; color: var(--dark);">Create Account</h2>
        <p style="color: var(--text);">Join the modern essentials collection.</p>
      </div>

      <?php if (isset($error)): ?>
        <div
          style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; border: 1px solid #fecaca;">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form action="/register" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">

        <div class="form-group">
          <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Full Name</label>
          <input type="text" name="name" required placeholder="John Doe"
            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
        </div>

        <div class="form-group">
          <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Email Address</label>
          <input type="email" name="email" required placeholder="name@company.com"
            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
        </div>

        <div class="form-group">
          <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">I am a...</label>
          <select name="role_id" required
            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white; outline: none;">
            <option value="2">Customer</option>
            <option value="1">Administrator</option>
          </select>
        </div>

        <div class="form-group">
          <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Password</label>
          <input type="password" name="password" required placeholder="••••••••"
            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
        </div>

        <div class="form-group">
          <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Confirm Password</label>
          <input type="password" name="confirm_password" required placeholder="••••••••"
            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
        </div>

        <button type="submit" class="btn-primary"
          style="width: 100%; border: none; font-size: 1rem; cursor: pointer; margin-top: 1rem;">
          Sign Up
        </button>
      </form>

      <div style="text-align: center; margin-top: 2rem; font-size: 0.95rem;">
        <span style="color: var(--text);">Already have an account?</span>
        <a href="/login"
          style="color: var(--primary); text-decoration: none; font-weight: 600; margin-left: 0.5rem;">Login</a>
      </div>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>