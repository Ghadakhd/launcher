<?php
class Trip {
    private $conn;
    private $table = "trips";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function getTableName() {
        return $this->table;
    }

    public function getTrips() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getTripById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTrip($destination, $description, $start_date, $price, $category, $imageData) {
        $query = "INSERT INTO " . $this->table . " (destination, description, start_date, price, category, image) 
                  VALUES (:destination, :description, :start_date, :price, :category, :image)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":destination", $destination);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":start_date", $start_date);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":category", $category);
        $stmt->bindParam(":image", $imageData, PDO::PARAM_LOB);
        return $stmt->execute();
    }

    public function updateTrip($id, $destination, $description, $start_date, $price, $category) {
        $query = "UPDATE " . $this->table . " SET destination = :destination, description = :description, 
                  start_date = :start_date, price = :price, category = :category WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":destination", $destination);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":start_date", $start_date);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":category", $category);

        return $stmt->execute();
    }

    public function deleteTrip($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    public function updatePopularity($id, $popularity) {
        $query = "UPDATE " . $this->table . " SET popularity = :popularity WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":popularity", $popularity);

        return $stmt->execute();
    }
}
?>