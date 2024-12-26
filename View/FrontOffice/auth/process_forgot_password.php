<?php
require_once '../includes/db.php';
require_once __DIR__ . '/send_email.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("SELECT iduser FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $resetToken = bin2hex(random_bytes(16));
            $expiresAt = date("Y-m-d H:i:s", strtotime("+1 hour"));

            $stmt = $conn->prepare("UPDATE user SET reset_token = ?, token_expiration = ? WHERE email = ?");
            $stmt->bind_param("sss", $resetToken, $expiresAt, $email);
            $stmt->execute();

            $resetLink = "http://yourwebsite.com/reset_password.php?token=$resetToken";
            mail($email, "Password Reset", "Click this link to reset your password: $resetLink");

            echo "Password reset instructions sent to your email.";
        } else {
            echo "No account associated with this email.";
        }
    } else {
        echo "Please enter a valid email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Forgot Password</title>
</head>
<body>
    <div class="form-box">
        <form action="" method="POST">
            <h1>Forgot Password</h1>
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
