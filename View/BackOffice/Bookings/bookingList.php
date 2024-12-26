<?php
include("../../../Controller/BookingController.php");

$controller = new BookingController();
$bookings = $controller->getBookings();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking List</title>
    <link href="../../../assets/css/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../../../assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="../../../assets/css/bookingList.css" rel="stylesheet">
</head>
<body>
    <h1>Booking List</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Date</th>
            <th>Destination</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($bookings as $booking): ?>
        <tr>
            <td><?= $booking['id'] ?></td>
            <td><?= $booking['name'] ?></td>
            <td><?= $booking['email'] ?></td>
            <td><?= $booking['booking_date'] ?></td>
            <td><?= $booking['destination'] ?></td>
            <td>
                <a href="updateBooking.php?id=<?= $booking['id'] ?>">Update</a>
                <a href="deleteBooking.php?id=<?= $booking['id'] ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
