<?php
include("../../../Controller/BookingController.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $controller = new BookingController();

    if ($controller->deleteBooking($id)) {
        header("Location: bookingList.php?message=Booking deleted successfully!");
        exit();
    } else {
        echo "Failed to delete booking.";
    }
} else {
    header("Location: bookingList.php");
    exit();
}
?>
