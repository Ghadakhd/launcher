<?php
// Include Database Connection
include '../config/db.php';

// Handle Delete User
if (isset($_GET['delete'])) {
    $userId = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM user WHERE iduser = $userId");
    header("Location: users.php");
    exit();
}

// Fetch Users
$result = mysqli_query($conn, "SELECT * FROM user");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
            color: #333;
        }
        .container {
            margin-top: 30px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            color: #0d6efd;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        table {
            border-collapse: collapse;
        }
        th {
            background-color: #0d6efd;
            color: #ffffff;
        }
        .btn {
            font-size: 0.9rem;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #fff;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-warning:hover, .btn-danger:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>User Management</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $user['iduser']; ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                <td><?php echo htmlspecialchars($user['date_of_birth']); ?></td>
                <td>
                    <!-- Edit User -->
                    <a href="editUser.php?id=<?php echo $user['iduser']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    
                    <!-- Delete User -->
                    <a href="?delete=<?php echo $user['iduser']; ?>" class="btn btn-danger btn-sm" 
                       onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
