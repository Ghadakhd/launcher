<?php
require_once '../../../controller/OrderController.php';
require_once '../../../controller/ProductController.php'; // To manage product stock

if (isset($_GET['id']) && isset($_GET['status'])) {
    $orderController = new OrderController();
    $productController = new ProductController();
    $orderId = intval($_GET['id']);
    $newStatus = $_GET['status'];

    try {
        $order = $orderController->getOrderById($orderId);
        if (!$order) {
            echo "<script>alert('Order not found.'); window.location.href = 'index.php';</script>";
            exit;
        }

        $orderedProductId = $order['ordered_P_ID'];
        $totalAmount = $order['TotalAmount']; 

       
        $product = $productController->getProductById($orderedProductId);
        if (!$product) {
            echo "<script>alert('Product not found.'); window.location.href = 'index.php';</script>";
            exit;
        }

        $productPrice = $product['Price'];
        $productStock = $product['Stock'];

        
        $orderedQuantity = $order['TotalAmount'] / $productPrice;

        error_log("Product stock before update: $productStock");
        error_log("Ordered quantity: $orderedQuantity");

        if ($newStatus === 'Approved') {
            
            if ($productStock < $orderedQuantity) {
                echo "<script>alert('Insufficient stock for this order.'); window.location.href = 'index.php';</script>";
                exit;
            }

            
            $newStock = $productStock - $orderedQuantity;

           
            $productController->updateStock($orderedProductId, $newStock);
        }

        $orderController->updateOrderStatus($orderId, $newStatus);
        echo "<script>alert('Order status updated successfully.'); window.location.href = 'index.php';</script>";
        exit;
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href = 'index.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Missing required parameters.'); window.location.href = 'index.php';</script>";
    exit;
}
