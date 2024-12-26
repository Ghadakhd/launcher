<?php
// Start the session
session_start();

// Include database connection or the UserController
include_once '../../../config.php'; // Database configuration
include_once '../../../Controller/UserController.php'; // UserController for data fetching

// Initialize UserController
$userController = new UserController();

// Check if the user is logged in (checking for a valid session)
if (isset($_SESSION['user_id'])) {
    // Get user data based on session user_id
    $user = $userController->getUserData($_SESSION['user_id']);
    
    if (!$user) {
        // If user data is not found, redirect to an error page or login page
        echo "User not found.";
        exit;
    }
} else {
    // If the user is not logged in, redirect to login page
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../auth/style.css">
    <title>My Account</title>
</head>
<body>
    <div class="form-box">
        <form>
            <h1>My Account</h1>

            <div class="input-box">
                <label for="username">Username:</label><br>
                <input type="text" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly><br>
            </div>

            <div class="input-box">
                <label for="email">Email:</label><br>
                <input type="text" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly><br>
            </div>

            <div class="input-box">
                <label for="name">Full Name:</label><br>
                <input type="text" id="name" value="<?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>" readonly><br>
            </div>

            <div class="input-box">
                <label for="dob">Date of Birth:</label><br>
                <input type="text" id="dob" value="<?php echo htmlspecialchars($user['date_of_birth']); ?>" readonly><br>
            </div>

            <div class="button-group">
                <a href="edit_account.php" class="btn">Edit Your Account</a>
                <a href="logout.php" class="btn">Logout</a>
            </div>
        </form>
    </div>
</body>
</html>
