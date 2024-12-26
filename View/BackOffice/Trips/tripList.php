<?php
include("../../../Controller/TripController.php");

$controller = new TripController();
$trips = $controller->getTrips();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trip List</title>
    <link href="../../../assets/css/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../../../assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="../../../assets/css/bookingList.css" rel="stylesheet">
</head>
<body>
    <h1>List of Trips</h1>
    <a href="addTrip.php">Add New Trip</a>
    <table>
        <thead>
            <tr>
                <th>Destination</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>Price</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trips as $trip): ?>
                <tr>
                    <td><?= htmlspecialchars($trip['destination']) ?></td>
                    <td><?= htmlspecialchars($trip['description']) ?></td>
                    <td><?= htmlspecialchars($trip['start_date']) ?></td>
                    <td><?= htmlspecialchars($trip['price']) ?></td>
                    <td><?= htmlspecialchars($trip['category']) ?></td>
                    <td>
                        <a href="updateTrip.php?id=<?= $trip['id'] ?>">Edit</a>
                        <a href="deleteTrip.php?id=<?= $trip['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
