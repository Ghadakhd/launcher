<?php
require_once '../../../controller/OrderController.php';

if (isset($_GET['id'])) {
    $orderController = new OrderController();
    $orderId = $_GET['id'];

    try {
        // Delete the order
        $orderController->deleteOrder($orderId);

        // Redirect back to the orders page
        header('Location: index.php?success=1');
        exit;
    } catch (Exception $e) {
        // Handle errors and redirect with an error message
        header('Location: index.php?error=' . urlencode($e->getMessage()));
        exit;
    }
} else {
    // Redirect back if required parameters are missing
    header('Location: index.php?error=Missing required parameters');
    exit;
}
?>
