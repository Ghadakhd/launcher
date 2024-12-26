<?php
// BookingController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../Model/Booking.php';

class BookingController {
    private $model;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->model = new Booking($db);
    }

    public function getBookings() {
        return $this->model->getBookings()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBooking($name, $email, $date, $destination, $id_trip) {
        return $this->model->addBooking($name, $email, $date, $destination, $id_trip);
    }

    public function updateBooking($id, $name, $email, $date, $destination, $id_trip) {
        return $this->model->updateBooking($id, $name, $email, $date, $destination, $id_trip);
    }

    public function deleteBooking($id) {
        return $this->model->deleteBooking($id);
    }
}
?>