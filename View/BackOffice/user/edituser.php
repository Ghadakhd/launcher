<?php
// Include Database Connection
include '../config/db.php';

// Check if ID is set and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = intval($_GET['id']);

    // Fetch User Data
    $result = mysqli_query($conn, "SELECT * FROM user WHERE iduser = $userId");
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        die("User not found!");
    }
} else {
    die("Invalid user ID.");
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $dateOfBirth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);

    // Update Query
    $updateQuery = "UPDATE user SET 
        username = '$username',
        email = '$email',
        first_name = '$firstName',
        last_name = '$lastName',
        date_of_birth = '$dateOfBirth'
        WHERE iduser = $userId";

    if (mysqli_query($conn, $updateQuery)) {
        // Redirect after successful update
        header("Location: users.php");
        exit();
    } else {
        $error = "Error updating user: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4faff;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            border: 3px solid #0d6efd;
            max-width: 600px;
        }
        h2 {
            color: #0d6efd;
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
        }
        .form-label {
            color: #0d6efd;
            font-weight: 600;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: scale(1.05);
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: scale(1.05);
        }
        .form-control {
            border: 2px solid #0d6efd;
            box-shadow: none;
        }
        .form-control:focus {
            border-color: #0b5ed7;
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit User</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" 
                   value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" 
                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" 
                   value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" 
                   value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" 
                   value="<?php echo htmlspecialchars($user['date_of_birth']); ?>" required>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="users.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    <footer>
        Inspired by <strong>Sidi Bou Said</strong> - The Blue and White Dream
    </footer>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
