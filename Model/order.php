<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Config.php';

class Order {
    // Fetch all orders
    public static function getAllOrders() {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT * FROM `Order`");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a specific order by ID
    public static function getOrderById($id) {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT * FROM `Order` WHERE OrderID = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new order
    public static function createOrder($data) {
        $db = Database::getConnection();
        $query = $db->prepare("INSERT INTO `Order` (UserID, OrderDate, TotalAmount, ordered_P_ID, Status) VALUES (?, ?, ?, ?, ?)");
        return $query->execute([
            $data['UserID'], 
            $data['OrderDate'] ?? null, // Optional, defaults to current timestamp
            $data['TotalAmount'], 
            $data['ordered_P_ID'], 
            $data['Status'] ?? 'Not Approved' // Default status
        ]);
    }

    // Update an existing order
    public static function updateOrder($id, $data) {
        $db = Database::getConnection();
        $query = $db->prepare("UPDATE `Order` SET UserID = ?, OrderDate = ?, TotalAmount = ?, ordered_P_ID = ?, Status = ? WHERE OrderID = ?");
        return $query->execute([
            $data['UserID'], 
            $data['OrderDate'], 
            $data['TotalAmount'], 
            $data['ordered_P_ID'], 
            $data['Status'], 
            $id
        ]);
    }

    // Update only the status of an order
    public static function updateStatus($id, $status) {
        $db = Database::getConnection();
        $query = $db->prepare("UPDATE `Order` SET Status = ? WHERE OrderID = ?");
        return $query->execute([$status, $id]);
    }

    // Delete an order by ID
    public static function deleteOrder($id) {
        $db = Database::getConnection();
        $query = $db->prepare("DELETE FROM `Order` WHERE OrderID = ?");
        return $query->execute([$id]);
    }
}
?>
