<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Config.php';

class Product {
    public static function getAllProducts() {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT * FROM Product");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProductById($id) {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT * FROM Product WHERE ProductID = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function createProduct($data) {
        $db = Database::getConnection();
        $query = $db->prepare("INSERT INTO Product (Name, Price, Stock, Type, Image) VALUES (?, ?, ?, ?, ?)");
        return $query->execute([$data['Name'], $data['Price'], $data['Stock'], $data['Type'], $data['Image']]);
    }

    public static function updateProduct($id, $data) {
        $db = Database::getConnection();
        $query = $db->prepare("UPDATE Product SET Name = ?, Price = ?, Stock = ?, Type = ?, Image = ? WHERE ProductID = ?");
        return $query->execute([$data['Name'], $data['Price'], $data['Stock'], $data['Type'], $data['Image'], $id]);
    }

    public static function deleteProduct($id) {
        $db = Database::getConnection();
        $query = $db->prepare("DELETE FROM Product WHERE ProductID = ?");
        return $query->execute([$id]);
    }
    public function reduceStock($productId, $quantity) {
        $product = $this->getProductById($productId);
        if ($product && $product['Stock'] >= $quantity) {
            $newStock = $product['Stock'] - $quantity;
            $this->updateProduct($productId, ['Stock' => $newStock] + $product);
            return true;
        }
        return false;
    }
    
}
?>
