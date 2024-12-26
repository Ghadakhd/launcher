<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .main-content {
            flex-grow: 1;
            background-color: #f8f9fa;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-3">
        <h3 class="text-center">Admin Dashboard</h3>
        <hr>
        <div class="nav flex-column">
            <!-- Module 1 -->
            <div class="mb-2">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#module1">Module 1</a>
                <div id="module1" class="collapse">
                    <a href="http://localhost/launcher/view/BackOffice/index.html" target="main-frame" class="nav-link ms-3">Monuments</a>
                    <a href="https://example.com/page2" target="main-frame" class="nav-link ms-3">Link 2</a>
                </div>
            </div>
            
            <!-- Module 2 -->
            <div class="mb-2">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#module1">Users Management</a>
              
                <div id="module1" class="collapse">
                    <a href="user/index.php" target="main-frame" class="nav-link ms-3">Manage Users</a>
                </div>
            </div>
            <!-- Module 3 -->
            <div class="mb-2">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#module3">Module 3</a>
                <div id="module3" class="collapse">
                    <a href="https://example.com/page5" target="main-frame" class="nav-link ms-3">Link 1</a>
                    <a href="https://example.com/page6" target="main-frame" class="nav-link ms-3">Link 2</a>
                </div>
            </div>
            <!-- Module 4 -->
            <div class="mb-2">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#module4">Travel Management</a>
                <div id="module4" class="collapse">
                    <a href="Bookings/bookingList.php" target="main-frame" class="nav-link ms-3">Bookings</a>
                    <a href="Trips/tripList.php" target="main-frame" class="nav-link ms-3">Trips</a>
                </div>
            </div>
            <!-- Module 5 -->
            <div class="mb-2">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#module5">Galleries Management</a>
                <div id="module5" class="collapse">
                    <a href="museum/index.php" target="main-frame" class="nav-link ms-3">Manage Exhibitions</a>
                    <a href="artifacts/index.php" target="main-frame" class="nav-link ms-3">Artifacts</a>
                </div>
            </div>

            <!-- Module 6 -->
            <div class="mb-2">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#module6">Shop Managment</a>
                <div id="module6" class="collapse">
                    <a href="products/index.php" target="main-frame" class="nav-link ms-3">Manage Product</a>
                    <a href="orders/index.php" target="main-frame" class="nav-link ms-3">Manage Orders</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <iframe name="main-frame" src="https://example.com/welcome"></iframe>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>