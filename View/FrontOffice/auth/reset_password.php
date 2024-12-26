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

<?php
require_once __DIR__ . '/../../../Model/usermodel.php'; // Adjust path to your User model

// Initialize variables
$error = "";
$success = "";
$token = $_GET['token'] ?? null;

// Start session for CSRF token management
session_start();

// Verify token existence in the URL
if (!$token) {
    $error = "Invalid or missing token.";
} else {
    $userModel = new User();
    $user = $userModel->getUserByResetToken($token);

    if (!$user) {
        $error = "Invalid or expired token.";
    }
}

// Generate CSRF token for form submission
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($user)) {
    // Check CSRF token validity
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Invalid request. Please try again.";
    } else {
        // Sanitize input
        $newPassword = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirm_password']);

        if ($newPassword !== $confirmPassword) {
            $error = "Passwords do not match.";
        } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $newPassword)) {
            $error = "Password must be at least 8 characters long and include at least one uppercase letter, one number, and one special character.";
        } else {
            // Hash the new password and update the database
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $userModel->updatePassword($user->getIdUser(), $hashedPassword);

            // Clear the reset token
            $userModel->clearResetToken($user->getIdUser());

            // Unset CSRF token
            unset($_SESSION['csrf_token']);

            $success = "Your password has been reset successfully. You can now <a href='login.php'>log in</a>.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../auth/style.css">
    <title>Reset Password</title>
</head>
<body>
    <div class="form-box">
        <?php if (!empty($error)): ?>
            <p style="color:red; text-align:center;"><?php echo $error; ?></p>
        <?php elseif (!empty($success)): ?>
            <p style="color:green; text-align:center;"><?php echo $success; ?></p>
        <?php else: ?>
            <form method="POST" action="">
                <h1>Reset Password</h1>

                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div class="input-box">
                    <label for="password">New Password:</label><br>
                    <input type="password" id="password" name="password" placeholder="Enter your new password" required><br>
                    <small>Password must be at least 8 characters long and include at least one uppercase letter, one number, and one special character.</small>
                </div>

                <div class="input-box">
                    <label for="confirm_password">Confirm Password:</label><br>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your new password" required><br>
                </div>

                <button type="submit" class="btn">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
