<?php
include("../../../Controller/TripController.php");

$controller = new TripController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $trips = $controller->getTrips();

    foreach ($trips as $trip) {
        if ($trip['id'] == $id) {
            $currentTrip = $trip;
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $destination = $_POST['destination'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    if ($controller->updateTrip($id, $destination, $description, $start_date, $price, $category)) {
        header("Location: tripList.php?message=Trip updated successfully!");
        exit();
    } else {
        $error = "Failed to update trip.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Trip</title>
    <link href="../../../assets/css/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../../../assets/css/sb-admin-2.css" rel="stylesheet">
</head>
<body>
    <h1>Update Trip</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $currentTrip['id'] ?>">
        <label>Destination:</label>
        <input type="text" name="destination" value="<?= $currentTrip['destination'] ?>"><br>

        <label>Description:</label>
        <textarea name="description"><?= $currentTrip['description'] ?></textarea><br>

        <label>Start Date:</label>
        <input type="date" name="start_date" value="<?= $currentTrip['start_date'] ?>"><br>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" value="<?= $currentTrip['price'] ?>"><br>

        <label>Category:</label>
        <input type="text" name="category" value="<?= $currentTrip['category'] ?>"><br>

        <button type="submit">Update Trip</button>
    </form>
</body>
</html>
