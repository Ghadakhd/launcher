<?php
include("../../../Controller/TripController.php");

$error = "";
$valid = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destination = $_POST['destination'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    if (empty($destination) || empty($description) || empty($start_date) || empty($price) || empty($category)) {
        $error = "All fields are required.";
    } else {
        $valid = 1;
    }

    // Image upload handling
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $error = "Image upload failed.";
    }

    if ($valid == 1 && empty($error)) {
        $controller = new TripController();
        if ($controller->addTrip($destination, $description, $start_date, $price, $category, $imageData)) {
            header("Location: tripList.php?message=Trip added successfully!");
            exit();
        } else {
            $error = "Failed to add trip.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Trip</title>
    <link href="../../../assets/css/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../../../assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="../../../assets/css/bookingList.css" rel="stylesheet">
</head>
<body>
    <h1>Add Trip</h1>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Destination:</label>
        <input type="text" name="destination" value="<?= htmlspecialchars($destination ?? '') ?>"><br>

        <label>Description:</label>
        <textarea name="description"><?= htmlspecialchars($description ?? '') ?></textarea><br>

        <label>Start Date:</label>
        <input type="date" name="start_date" value="<?= htmlspecialchars($start_date ?? '') ?>"><br>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" value="<?= htmlspecialchars($price ?? '') ?>"><br>

        <label>Category:</label>
        <input type="text" name="category" value="<?= htmlspecialchars($category ?? '') ?>"><br>

        <label>Image:</label>
        <input type="file" name="image"><br>

        <button type="submit">Add Trip</button>
    </form>
</body>
</html>
