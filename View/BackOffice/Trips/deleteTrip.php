<?php
include("../../../Controller/TripController.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $controller = new TripController();

    if ($controller->deleteTrip($id)) {
        header("Location: tripList.php?message=Trip deleted successfully!");
        exit();
    } else {
        echo "Failed to delete trip.";
    }
} else {
    header("Location: tripList.php");
    exit();
}
?>
