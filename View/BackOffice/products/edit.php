<?php
require_once '../../../controller/ProductController.php';

$productController = new ProductController();
$product = $productController->getProductById($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productController->updateProduct($_GET['id'], $_POST);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="../../../assets/css/form.css">
</head>
<body>
    <h1>Edit Product</h1>
    <form method="POST" id="editProductForm">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" id="name" name="Name" value="<?php echo htmlspecialchars($product['Name']); ?>">
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label>Price:</label>
            <input type="number" id="price" name="Price" step="0.01" value="<?php echo htmlspecialchars($product['Price']); ?>">
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label>Stock:</label>
            <input type="number" id="stock" name="Stock" value="<?php echo htmlspecialchars($product['Stock']); ?>">
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label>Type:</label>
            <select id="type" name="Type">
                <option value="">Select a type</option>
                <option value="Men" <?php echo $product['Type'] === 'Men' ? 'selected' : ''; ?>>Men</option>
                <option value="Women" <?php echo $product['Type'] === 'Women' ? 'selected' : ''; ?>>Women</option>
                <option value="Artisanal" <?php echo $product['Type'] === 'Artisanal' ? 'selected' : ''; ?>>Artisanal</option>
            </select>
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label>Image:</label>
            <div id="dropZone">
                <p>Drag and drop an image here or click to upload</p>
                <input type="file" id="imageInput" name="Image" accept="image/*">
            </div>
            <img id="imagePreview" src="<?php echo htmlspecialchars($product['Image']); ?>" alt="Image Preview" style="display: <?php echo $product['Image'] ? 'block' : 'none'; ?>; max-width: 200px; margin-top: 10px;">
            <span class="error"></span>
        </div>

        <button type="submit">Update Product</button>
    </form>
    <script src="../../../assets/js/drag-and-drop.js"></script>
    <script src="../../../assets/js/formval.js"></script>
</body>
</html>
