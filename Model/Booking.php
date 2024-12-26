<?php
class Booking {
    private $conn;
    private $table = "bookings";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getBookings() {
        $query = "SELECT b.id, b.name, b.email, b.booking_date, b.destination, b.id_trip, t.destination AS trip_destination
                  FROM " . $this->table . " b
                  LEFT JOIN trips t ON b.id_trip = t.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function addBooking($name, $email, $date, $destination, $id_trip) {
        $query = "INSERT INTO " . $this->table . " (name, email, booking_date, destination, id_trip) 
                  VALUES (:name, :email, :date, :destination, :id_trip)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":destination", $destination);
        $stmt->bindParam(":id_trip", $id_trip);

        return $stmt->execute();
    }

    public function updateBooking($id, $name, $email, $date, $destination, $id_trip) {
        $query = "UPDATE " . $this->table . " SET name = :name, email = :email, booking_date = :date, destination = :destination, id_trip = :id_trip WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":destination", $destination);
        $stmt->bindParam(":id_trip", $id_trip);

        return $stmt->execute();
    }

    public function deleteBooking($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    public function getBookingCountByTrip() {
        $query = "SELECT id_trip, COUNT(*) as booking_count FROM " . $this->table . " GROUP BY id_trip";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>