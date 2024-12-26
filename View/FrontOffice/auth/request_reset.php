<?php
require_once __DIR__ . '/../../../Model/Usermodel.php';
require_once __DIR__ . '/send_email.php'; // PHPMailer setup file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $userModel = new User();
        $user = $userModel->getUserByEmail($email);

        if ($user) {
            // Generate reset token and expiration
            $resetToken = bin2hex(random_bytes(16));
            $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Save token to database
            $userModel->saveResetToken($email, $resetToken, $expiresAt);

            // Send reset email
            $resetLink = "http://yourwebsite.com/View/FrontOffice/auth/reset_password.php?token=" . urlencode($resetToken);
            $subject = "Password Reset Request";
            $message = "Hello, \n\nYou requested a password reset. Click the link below to reset your password:\n\n" . $resetLink . "\n\nIf you didn't request this, please ignore this email.";

            if (sendEmail($email, $subject, $message)) {
                $success = "Password reset instructions have been sent to your email.";
            } else {
                $error = "Failed to send the email. Please try again.";
            }
        } else {
            $error = "No account associated with this email.";
        }
    } else {
        $error = "Please enter a valid email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Forgot Password</title>
</head>
<body>
    <div class="form-box">
        <form action="" method="POST">
            <h1>Forgot Password</h1>
            <?php if (!empty($error)): ?>
                <p style="color:red; text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php elseif (!empty($success)): ?>
                <p style="color:green; text-align:center;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <div class="input-box">
                <label for="email">Enter Your Email:</label><br>
                <input type="email" id="email" name="email" placeholder="Enter your email" required><br>
            </div>
            <button type="submit" class="btn">Send Reset Link</button>
            <p>
                <a href="login.php" style="color: #7494ec; text-decoration: none; font-weight: 600;">Back to Login</a>
            </p>
        </form>
    </div>
</body>
</html>
