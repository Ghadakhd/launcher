<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Model/Product.php';

class ProductController {
    public function getProducts() {
        return Product::getAllProducts();
    }

    public function getAllProducts() {
        return Product::getAllProducts();
    }

    public function getProductById($id) {
        return Product::getProductById($id);
    }

    public function createProduct($data) {
        return Product::createProduct($data);
    }

    public function updateProduct($id, $data) {
        return Product::updateProduct($id, $data);
    }

    public function deleteProduct($id) {
        return Product::deleteProduct($id);
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
    // Add the method to update stock
    public function updateStock($productId, $newStock) {
        $db = Database::getConnection();
        $query = $db->prepare("UPDATE Product SET Stock = ? WHERE ProductID = ?");
        if ($query->execute([$newStock, $productId])) {
            error_log("Stock for product ID $productId updated to $newStock");
        } else {
            error_log("Failed to update stock for product ID $productId");
            echo "<script>alert('Failed to update stock for product ID $productId'); window.location.href = 'index.php';</script>";
            exit;
        }
    }
    

}
?>
