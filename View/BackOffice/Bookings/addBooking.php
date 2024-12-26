j<?php
include_once("../../../Controller/BookingController.php");
include_once("../../../Controller/TripController.php"); // Include TripController

$error = "";
$valid = 0;

// Fetch trips for the dropdown
$tripController = new TripController();
$trips = $tripController->getTrips();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['booking_date'];
    $id_trip = $_POST['id_trip']; // Get id_trip

    // Fetch destination based on id_trip
    $trip = $tripController->getTripById($id_trip);
    if ($trip) {
        $destination = $trip['destination'];
    } else {
        $error = "Selected trip does not exist.";
    }

    // Validation patterns
    $namePattern = '/^[A-Za-z\s\-]+$/';
    $emailPattern = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/';

    // Validate name
    if (!preg_match($namePattern, $name)) {
        $error = "Invalid name. Name should only contain letters, spaces, or hyphens.";
    }
    // Validate email
    elseif (!preg_match($emailPattern, $email)) {
        $error = "Invalid email format. Please provide a valid email address.";
    }
    // Validate date (should not be in the past)
    elseif (new DateTime($date) < new DateTime()) {
        $error = "Invalid date. Booking date cannot be in the past.";
    }
    // Validate id_trip
    elseif (!filter_var($id_trip, FILTER_VALIDATE_INT)) {
        $error = "Invalid trip selection.";
    } else {
        $valid = 1; // All validations passed
    }

    // If all inputs are valid, process the booking
    if ($valid == 1) {
        $controller = new BookingController();
        if ($controller->addBooking($name, $email, $date, $destination, $id_trip)) {
            header("Location: bookingList.php?message=Booking added successfully!");
            exit();
        } else {
            $error = "Failed to add booking.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Booking</title>
    <link href="../../../assets/css/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../../../assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="../../../assets/css/bookingList.css" rel="stylesheet">
</head>
<body>
    <h1>Add Booking</h1>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form id="BookingForm" method="POST" class='form-control'>
        <label>Name:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($name ?? '') ?>">
        <span id="name_error"></span><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
        <span id="email_error"></span><br>

        <label>Date:</label>
        <input type="date" name="booking_date" value="<?= htmlspecialchars($date ?? '') ?>">
        <span id="date_error"></span><br>

        <!-- Trip Selection Field -->
        <label for="id_trip">Select Trip:</label>
        <select name="id_trip" id="id_trip">
            <?php foreach ($trips as $trip): ?>
                <option value="<?= $trip['id'] ?>" <?= (isset($id_trip) && $id_trip == $trip['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($trip['destination']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span id="id_trip_error"></span><br>

        <button type="submit">Add Booking</button>
    </form>
</body>
</html>
