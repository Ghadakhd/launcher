<?php
include("../../../Controller/BookingController.php");

$controller = new BookingController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $bookings = $controller->getBookings();

    foreach ($bookings as $booking) {
        if ($booking['id'] == $id) {
            $currentBooking = $booking;
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['booking_date'];
    $destination = $_POST['destination'];
    $id_trip = $_POST['id_trip'];

    if ($controller->updateBooking($id, $name, $email, $date, $destination, $id_trip)) {
        header("Location: bookingList.php?message=Booking updated successfully!");
        exit();
    } else {
        $error = "Failed to update booking.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Booking</title>
    <link href="../../../assets/css/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../../../assets/css/sb-admin-2.css" rel="stylesheet">
</head>
<body>
    <h1>Update Booking</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $currentBooking['id'] ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?= $currentBooking['name'] ?>">
        <span id="name_error"></span><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?= $currentBooking['email'] ?>">
        <span id="email_error"></span><br>
        <label>Date:</label>
        <input type="date" name="booking_date" value="<?= $currentBooking['booking_date'] ?>">
        <span id="date_error"></span><br>
        <label>Destination:</label>
        <input type="text" name="destination" value="<?= $currentBooking['destination'] ?>">
        <span id="destination_error"></span><br>
        <label>Trip ID:</label>
        <input type="text" name="id_trip" value="<?= $currentBooking['id_trip'] ?>">
        <span id="id_trip_error"></span><br>
        <button type="submit">Update Booking</button>
    </form>
    <script src="BookingCrud/updateBooking.js"></script>
</body>
</html>
