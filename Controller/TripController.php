<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../Model/Trip.php';
require_once __DIR__ . '/../Model/Booking.php'; // Ensure Booking model is included only once

class TripController {
    private $model;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->model = new Trip($db);
    }

    public function getTrips() {
        return $this->model->getTrips()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTripById($id) {
        return $this->model->getTripById($id);
    }

    public function addTrip($destination, $description, $start_date, $price, $category, $imageData) {
        return $this->model->addTrip($destination, $description, $start_date, $price, $category, $imageData);
    }

    public function updateTrip($id, $destination, $description, $start_date, $price, $category) {
        return $this->model->updateTrip($id, $destination, $description, $start_date, $price, $category);
    }

    public function deleteTrip($id) {
        return $this->model->deleteTrip($id);
    }

    public function updateTripPopularity() {
        $bookingModel = new Booking($this->model->getConnection());
        $bookings = $bookingModel->getBookingCountByTrip();

        $totalBookings = array_sum(array_column($bookings, 'booking_count'));
        if ($totalBookings == 0) return;

        foreach ($bookings as $booking) {
            $popularity = ($booking['booking_count'] / $totalBookings) * 100;
            $this->model->updatePopularity($booking['id_trip'], $popularity);
        }
    }

    public function getTripOfTheWeek() {
        $query = "SELECT * FROM " . $this->model->getTableName() . " ORDER BY popularity DESC LIMIT 1";
        $stmt = $this->model->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
