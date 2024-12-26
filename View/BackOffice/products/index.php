<?php
require_once '../../../controller/ProductController.php';
$productController = new ProductController();
$products = $productController->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-12">
                <h1 class="text-center">Manage Products</h1>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 text-end">
                <a href="create.php" class="btn btn-primary">Add New Product</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Type</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $product['ProductID']; ?></td>
                                    <td><?php echo htmlspecialchars($product['Name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['Price']); ?> Dt</td>
                                    <td><?php echo htmlspecialchars($product['Stock']); ?></td>
                                    <td><?php echo htmlspecialchars($product['Type']); ?></td>
                                    <td>
                                    <img 
                                            src="assets/images/<?php echo htmlspecialchars($product['Image']); ?>" 
                                            alt="Image" 
                                            class="img-thumbnail" 
                                            style="width: 80px;">
                                    </td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $product['ProductID']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="delete.php?id=<?php echo $product['ProductID']; ?>" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No products found.</td>
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