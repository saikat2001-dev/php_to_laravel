<?php include __DIR__ . '/../partials/header.php'; ?>

<main class="container">
  <div class="auth-wrapper" style="max-width: 450px; margin: 5rem auto;">
    <div class="product-card" style="padding: 2.5rem;">
      <div style="text-align: center; margin-bottom: 2rem;">
        <h2 style="font-size: 2rem; color: var(--dark); margin-bottom: 0.5rem;">Welcome Back</h2>
        <p style="color: var(--text);">Please enter your details to sign in.</p>
      </div>

      <?php if (isset($error)): ?>
        <div
          style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; border: 1px solid #fecaca; text-align: center;">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <?php
      $success_message = null;
      if (isset($_GET['registered'])) {
        $success_message = "Registration successful! Please login.";
      } elseif (isset($_GET['message']) && $_GET['message'] === 'logged_out') {
        $success_message = "You have been successfully logged out.";
      }
      ?>

      <?php if ($success_message): ?>
        <div
          style="background: #dcfce7; color: #15803d; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; border: 1px solid #bbf7d0; text-align: center;">
          <?= htmlspecialchars($success_message) ?>
        </div>
      <?php endif; ?>

      <form action="/login?redirect_to=<?php echo htmlspecialchars($_GET['redirect_to'] ?? '/'); ?>" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">

        <div class="form-group">
          <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Email Address</label>
          <input type="email" name="email" required placeholder="email@example.com"
            style="width: 100%; padding: 0.85rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; transition: border-color 0.2s;">
        </div>

        <div class="form-group">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
            <label style="font-weight: 500;">Password</label>
            <a href="#" style="font-size: 0.85rem; color: var(--primary); text-decoration: none;">Forgot password?</a>
          </div>
          <input type="password" name="password" required placeholder="••••••••"
            style="width: 100%; padding: 0.85rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
        </div>

        <button type="submit" class="btn-primary"
          style="width: 100%; border: none; font-size: 1rem; cursor: pointer; margin-top: 0.5rem; padding: 0.85rem;">
          Sign In
        </button>
      </form>

      <div style="text-align: center; margin-top: 2rem; font-size: 0.95rem;">
        <span style="color: var(--text);">Don't have an account?</span>
        <a href="/register"
          style="color: var(--primary); text-decoration: none; font-weight: 600; margin-left: 0.5rem;">Create
          account</a>
      </div>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>