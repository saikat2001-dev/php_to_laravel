<?php

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
  public static function sendOrderConfirmation($recipientEmail, $orderId, $total)
  {
    $mail = new PHPMailer(true);

    try {
      // Server settings (Use Gmail, SendGrid, or Mailtrap for testing)
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com'; // Your SMTP provider
      $mail->SMTPAuth   = true;
      $mail->Username   = 'saikatdas40g@gmail.com';
      $mail->Password   = $_ENV['GOOGLE_PASSWORD'];
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port       = 587;

      // Recipients
      $mail->setFrom('saikatdas40g@gmail.com', COMPANY_NAME);
      $mail->addAddress($recipientEmail);

      // Content
      $mail->isHTML(true);
      $mail->Subject = "Order Confirmed: #$orderId";
      $mail->Body    = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <h2>Thank you for your order!</h2>
                    <p>We've received your payment for order <strong>#$orderId</strong>.</p>
                    <p><strong>Total Amount:</strong> ₹" . number_format($total, 2) . "</p>
                    <p>We will notify you once your items have shipped.</p>
                    <br>
                    <a href='http://localhost:8000/my-orders' style='background: #3b82f6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>View Order Status</a>
                    <p>Best regards,<br>" . COMPANY_NAME . " Team</p>
                </div>
            ";

      $mail->send();
      return true;
    } catch (Exception $e) {
      error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
      return false;
    }
  }
}
