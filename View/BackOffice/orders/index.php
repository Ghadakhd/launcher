<?php
require_once '../../../controller/OrderController.php';
require_once '../../../controller/ProductController.php'; // To manage product stock

$orderController = new OrderController();
$productController = new ProductController();
$orders = $orderController->getAllOrders();

// Filter orders with a non-empty status
$filteredOrders = array_filter($orders, function($order) {
    return !empty($order['Status']);
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-12">
                <h1 class="text-center">Manage Orders</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th>Order Date</th>
                            <th>Total Price</th>
                            <th>Ordered Item</th> <!-- New Column -->
                            <th>Ordered Quantity</th>  <!-- New Column -->
                            <th>Available Stock</th>   <!-- New Column -->
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($filteredOrders)): ?>
                            <?php foreach ($filteredOrders as $order): 
                                // Fetch product details for each order
                                $orderedProductId = $order['ordered_P_ID'];
                                $product = $productController->getProductById($orderedProductId);
                                if ($product) {
                                    // Calculate ordered quantity from the total amount
                                    $orderedQuantity = round($order['TotalAmount'] / $product['Price']);
                                    $availableStock = $product['Stock'];
                                    $productName = $product['Name'];  // Get product name
                                }
                                ?>
                                <tr>
                                    <td><?php echo $order['OrderID']; ?></td>
                                    <td><?php echo htmlspecialchars($order['UserID']); ?></td>
                                    <td><?php echo htmlspecialchars($order['OrderDate']); ?></td>
                                    <td><?php echo htmlspecialchars($order['TotalAmount']); ?> Dt</td>
                                    <td><?php echo htmlspecialchars($productName); ?></td>  <!-- Display Ordered Item Name -->
                                    <td><?php echo $orderedQuantity; ?></td>  <!-- Display Ordered Quantity -->
                                    <td><?php echo $availableStock; ?></td>  <!-- Display Available Stock -->
                                    <td><?php echo htmlspecialchars($order['Status']); ?></td>
                                    <td>
                                        <?php if ($order['Status'] === 'Not Approved'): ?>
                                            <!-- Approve Button -->
                                            <a href="update_status.php?id=<?php echo $order['OrderID']; ?>&status=Approved" class="btn btn-sm btn-success">Approve</a>
                                        <?php endif; ?>

                                        <?php if ($order['Status'] === 'Approved'): ?>
                                            <!-- Deliver Button -->
                                            <a href="update_status.php?id=<?php echo $order['OrderID']; ?>&status=Delivered" class="btn btn-sm btn-primary">Mark as Delivered</a>
                                        <?php endif; ?>

                                        <!-- Delete Button -->
                                        <a href="delete.php?id=<?php echo $order['OrderID']; ?>" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
