<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Controller/MuseumController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare museum data
    $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'image' => 'images/' . $_FILES['image']['name'],
        'location' => $_POST['location'],
    ];

    // Move the uploaded image to the images directory
    move_uploaded_file($_FILES['image']['tmp_name'], '../' . $data['image']);

    // Create museum in the database
    $controller = new MuseumController();
    $controller->createMuseum($data);

    // Redirect to the museum list
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Museum</title>
    <link rel="stylesheet" href="../../../assets/css/form.css">
</head>
<body>
    <h1>Add New Museum</h1>
    <form method="POST" enctype="multipart/form-data" id="museumForm">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <div id="dropZone">
                <p>Drag and drop an image here or click to upload</p>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 200px; margin-top: 10px;">
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location">
            <span class="error"></span>
        </div>

        <button type="submit">Add Museum</button>
    </form>

    <script src="../../../assets/js/drag-and-drop.js"></script>
    <script src="../../../assets/js/formmuseumval.js"></script>
</body>
</html>