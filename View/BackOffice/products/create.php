<?php
require_once '../../../controller/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productController = new ProductController();
    $productController->createProduct($_POST);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="../../../assets/css/form.css">
</head>
<body>
    <h1>Add New Product</h1>
    <form method="POST" id="productForm">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" id="name" name="Name">
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label>Price:</label>
            <input type="number" id="price" name="Price" step="0.01">
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label>Stock:</label>
            <input type="number" id="stock" name="Stock">
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label>Type:</label>
            <select id="type" name="Type">
                <option value="">Select a type</option>
                <option value="Men">Men</option>
                <option value="Women">Women</option>
                <option value="Artisanal">Artisanal</option>
            </select>
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label>Image:</label>
            <div id="dropZone">
                <p>Drag and drop an image here or click to upload</p>
                <input type="file" id="imageInput" name="Image" accept="image/*">
            </div>
            
            <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 200px; margin-top: 10px;">
            <span class="error"></span>
        </div>

        <button type="submit">Add Product</button>
    </form>
    <script src="../../../assets/js/drag-and-drop.js"></script>
    <script src="../../../assets/js/formval.js"></script>
</body>
</html>
