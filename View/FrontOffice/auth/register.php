<?php
// Include required files
include_once '../../../Controller/UserController.php';
include_once '../../../config.php';

// Initialize the UserController
$userController = new UserController();

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user inputs
    $username = htmlspecialchars(trim($_POST['username']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $dateOfBirth = $_POST['date_of_birth']; // Date format should be validated later

    // Validate inputs
    $errors = [];
    if (empty($username)) $errors[] = "Username is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($password) || strlen($password) < 6) $errors[] = "Password must be at least 6 characters long.";
    if ($password !== $confirmPassword) $errors[] = "Passwords do not match.";
    if (empty($dateOfBirth)) $errors[] = "Date of birth is required.";

    // Proceed if there are no errors
    if (empty($errors)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create a User object
        $user = new User(
            null, // ID is auto-generated
            $username,
            $email,
            $hashedPassword,
            $firstName,
            $lastName,
            $dateOfBirth
        );

        // Use the controller to add the user to the database
        try {
            $userController->addUser($user);
            echo "User registered successfully!";
            $userId = $userController->getUserIdByUsername($username); // Assuming getUserIdByUsername fetches the user ID
            $_SESSION['user_id'] = $userId;
            header("Location: myAccount.php?signup_success=true");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>

<!-- HTML Sign-Up Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../auth/style.css">
    <script src="../../../assets/js/user.js" defer></script> <!-- Correct link to your script.js -->
    <title>Sign Up</title>
</head>
<body>
    <div class="form-box">
        <form id="signupForm" action="register.php" method="POST">
            <h1>Sign Up</h1>
            <div class="input-box">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" placeholder="Enter your username" ><br>
                <span id="usernameError" style="color:red; display:none;"></span> <!-- Error message for username -->
            </div>

            <div class="input-box">
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" placeholder="Enter your email" ><br>
                <span id="emailError" style="color:red; display:none;"></span> <!-- Error message for email -->
            </div>

            <div class="input-box">
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" placeholder="Enter your password" ><br>
                <span id="passwordError" style="color:red; display:none;"></span> <!-- Error message for password -->
            </div>

            <div class="input-box">
                <label for="confirm_password">Confirm Password:</label><br>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" ><br>
                <span id="confirmPasswordError" style="color:red; display:none;"></span> <!-- Error message for confirm password -->
            </div>

            <div class="input-box">
                <label for="first_name">First Name:</label><br>
                <input type="text" id="first_name" name="first_name" placeholder="Enter your first name"><br>
            </div>

            <div class="input-box">
                <label for="last_name">Last Name:</label><br>
                <input type="text" id="last_name" name="last_name" placeholder="Enter your last name"><br>
            </div>

            <div class="input-box">
                <label for="date_of_birth">Date of Birth:</label><br>
                <input type="date" id="date_of_birth" name="date_of_birth" ><br>
            </div>

            <button type="submit" class="btn">Sign Up</button>
            <p style="font-size: 14px; margin-top: 15px;">
                Already have an account? 
                <a href="login.php" onclick="changeIframeSource('login.php')" style="color: #7494ec; text-decoration: none; font-weight: 600;">Sign In</a>
            </p>

        </form>
    </div>
</body>
</html>
