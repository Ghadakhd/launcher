<?php
// Start the session
session_start();

// Include database connection and the UserController
include_once '../../../config.php'; // Database configuration
include_once '../../../Controller/UserController.php'; // UserController for user operations
include_once '../../../Model/Usermodel.php'; // User model

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit;
}

// Initialize UserController
$userController = new UserController();

// Get current user data
$user = $userController->getUserData($_SESSION['user_id']);
if (!$user) {
    echo "User not found.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a User object with updated data
    $updatedUser = new User();
    $updatedUser->setUsername($_POST['username']);
    $updatedUser->setEmail($_POST['email']);
    
    // Update password only if provided
    $password = $_POST['password'];
    if (!empty($password)) {
        $updatedUser->setPassword(password_hash($password, PASSWORD_BCRYPT)); // Hash the password
    } else {
        $updatedUser->setPassword($user['password']); // Keep the current password
    }
    
    $updatedUser->setFirstName($_POST['first_name']);
    $updatedUser->setLastName($_POST['last_name']);
    $updatedUser->setDateOfBirth($_POST['date_of_birth']);
    $updatedUser->setRole($user['role']); // Keep the current role

    // Update user in the database
    if ($userController->updateUser($updatedUser, $_SESSION['user_id'])) {
        // Redirect to my account page after successful update
        header("Location: myaccount.php?update=success");
        exit;
    } else {
        $error = "Failed to update profile. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../auth/style.css">
    <title>Edit Account</title>
</head>
<body>
    <div class="form-box">
        <form method="POST" action="edit_account.php">
            <h1>Edit Your Account</h1>

            <?php if (isset($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <div class="input-box">
                <label for="username">Username:</label><br>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>
            </div>

            <div class="input-box">
                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
            </div>

            <div class="input-box">
                <label for="password">New Password (leave blank to keep current):</label><br>
                <input type="password" name="password" id="password"><br>
            </div>

            <div class="input-box">
                <label for="first_name">First Name:</label><br>
                <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required><br>
            </div>

            <div class="input-box">
                <label for="last_name">Last Name:</label><br>
                <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required><br>
            </div>

            <div class="input-box">
                <label for="date_of_birth">Date of Birth:</label><br>
                <input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo htmlspecialchars($user['date_of_birth']); ?>" required><br>
            </div>

            <div class="button-group">
                <button type="submit" class="btn">Save Changes</button>
                <a href="myaccount.php" class="btn">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
