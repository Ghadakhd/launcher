<?php
require_once '../../../controller/MuseumController.php';

$museumController = new MuseumController();
$museum = $museumController->getMuseumById($_GET['id']); // Fetch museum by ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare data from POST request
    $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'location' => $_POST['location'],
    ];

    // Check if a new image was uploaded
    if (!empty($_FILES['image']['name'])) {
        $data['image'] = 'images/' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../../../' . $data['image']);
    } else {
        $data['image'] = $museum['image']; // Retain old image if no new one
    }

    // Update museum data
    $museumController->updateMuseum($_GET['id'], $data);

    header('Location: index.php'); // Redirect to the index page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Museum</title>
    <link rel="stylesheet" href="../../../assets/css/form.css">
</head>
<body>
    <h1>Edit Museum</h1>
    <form method="POST" enctype="multipart/form-data" id="editMuseumForm">
        <input type="hidden" name="id" value="<?= htmlspecialchars($museum['id']); ?>">

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($museum['name']); ?>" required>
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($museum['description']); ?></textarea>
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?= htmlspecialchars($museum['location']); ?>" required>
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <div id="dropZone">
                <p>Drag and drop an image here or click to upload</p>
                <input type="file" id="imageInput" name="image" accept="image/*">
            </div>
            <?php if ($museum['image']): ?>
                <img id="imagePreview" src="../../../<?= htmlspecialchars($museum['image']); ?>" alt="Image Preview" style="max-width: 200px; margin-top: 10px;">
            <?php endif; ?>
            <span class="error"></span>
        </div>

        <button type="submit">Update Museum</button>
    </form>

    <script src="../../../assets/js/drag-and-drop.js"></script>
    <script src="../../../assets/js/formval.js"></script>
</body>
</html>
