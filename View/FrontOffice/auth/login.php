<?php
session_start();
require_once __DIR__ . '/../../../Model/usermodel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($username && $password) {
        $userModel = new UserModel();
        $user = $userModel->getUserByUsername($username); // Fetch user by username

        if ($user && password_verify($password, $user->getPassword())) {
            $_SESSION['user_id'] = $user->getIdUser();
            $_SESSION['role'] = $user->getRole();

            // Redirect based on role
            if ($user->getRole() === 'admin') {
                header('Location: ../../backoffice/dashboard.php');
            } else {
                header('Location: ../../../index.php');
            }
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Both username and password are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../auth/style.css">
    <script src="../../../assets/js/user.js" defer></script>
    <title>Login</title>
</head>
<body>
    <div class="form-box">
        <form id="loginForm" action="login.php" method="POST">
            <h1>Login</h1>

            <?php if (!empty($error)): ?>
                <p style="color:red; text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <div class="input-box">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" placeholder="Enter your username" required><br>
                <span id="usernameError" style="color:red; display:none;"></span>
            </div>

            <div class="input-box">
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" placeholder="Enter your password" required><br>
                <span id="passwordError" style="color:red; display:none;"></span>
            </div>

            <button type="submit" class="btn">Login</button>

            <p style="font-size: 14px; margin-top: 15px;">
                <a href="forgot_password.php" style="color: #7494ec; text-decoration: none; font-weight: 600;">Forgot Password?</a>
            </p>

            <p style="font-size: 14px; margin-top: 15px;">
                Don't have an account? 
                <a href="register.php" style="color: #7494ec; text-decoration: none; font-weight: 600;">Sign Up</a>
            </p>
        </form>
    </div>
</body>
</html>
