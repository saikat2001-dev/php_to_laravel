<?php
// require_once 'vendor/autoload.php';

\Stripe\Stripe::setApiKey("$_ENV[STRIPE_SECRET_KEY]"); // Use your actual sk_test_... key

define('STRIPE_PUBLISHABLE_KEY', "$_ENV[STRIPE_PUBLISHABLE_KEY]"); // Use your actual pk_test_... key

return [
  'secret_key' => "$_ENV[STRIPE_SECRET_KEY]"
];